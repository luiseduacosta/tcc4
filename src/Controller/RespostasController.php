<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;
/**
 * Respostas Controller
 *
 * @property \App\Model\Table\RespostasTable $Respostas
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RespostasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Respostas->find()
            ->contain(['Estagiarios' => ['Alunos']])
            ->order(['Respostas.id' => 'DESC']);
        $respostas = $this->paginate($query);
        $this->set(compact('respostas'));
    }

    /**
     * View method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resposta = $this->Respostas->get($id, [
            'contain' => ['Estagiarios' => ['Alunos']],
        ]);
        $respostas = json_decode($resposta->response, true);
        // pr($respostas);
        $avaliacoes = [];
        // die();
        foreach ($respostas as $key => $value) {
            // echo substr($key, 0, 9) . ' ' . $value . '<br>';
            if (substr($key, 0, 9) == 'avaliacao') {
                $pergunta_id = (int) substr($key, 9, 2);
                $pergunta = $this->fetchTable('Questiones')->get(intval($pergunta_id));
                if ($pergunta->type == 'select' || $pergunta->type == 'radio' || $pergunta->type == 'checkbox' || $pergunta->type == 'boolean') {
                    $opcoes = json_decode($pergunta->options, true);
                    foreach ($opcoes as $option_key => $option_value) {
                        if ($option_key == $value) {
                            $avaliacoes[$pergunta->text] = $option_value;
                            // unset($avaliacoes[$option_key]);
                            // unset($avaliacoes[$option_value]);
                        }
                    }
                } else {
                    $avaliacoes[$pergunta->text] = $value;
                }
            }
        }
        $this->Authorization->skipAuthorization();
        $this->set(compact('resposta', 'avaliacoes'));
    }

    /**
     * Add method
     * @property mixed $estagiario_id
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();

        $estagiario_id = $this->request->getQuery('estagiario_id');
        if (!$estagiario_id) {
            $this->Flash->error(__('Estagiário não informado.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $estagiario = $this->fetchTable('Estagiarios')->find()
                ->contain(['Alunos'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
            if (!$estagiario) {
                $this->Flash->error(__('Estagiário não localizado.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $resposta = $this->Respostas->find()
                    ->where(['Respostas.estagiarios_id' => $estagiario_id])
                    ->first();
                if ($resposta) {
                    $this->Flash->error(__('Este estagiário já possui uma avaliação preenchida.'));
                    return $this->redirect(['action' => 'view', $resposta->id]);
                }
                $this->set('estagiario', $estagiario);
            }
        }
        $resposta = $this->Respostas->newEmptyEntity();
        if ($this->request->getData()) {
            // pr($this->request->getData('estagiario_id'));
            //
            // die();
        }
        if ($this->request->is('post')) {
            $resposta = json_encode($this->request->getData(), JSON_PRETTY_PRINT);
            $data['question_id'] = $this->request->getData('question_id') ?? 1;
            $data['estagiarios_id'] = $this->request->getData('estagiario_id');
            $data['response'] = json_encode($this->request->getData(), JSON_PRETTY_PRINT);
            $data['created'] = FrozenTime::now();
            $data['modified'] = FrozenTime::now();
            // pr($data);
            // die();
            $resposta = $this->Respostas->newEmptyEntity();
            $resposta = $this->Respostas->patchEntity($resposta, $data);

            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Respuesta inserida.'));
                return $this->redirect(['action' => 'view', $resposta->id]);
            } else {
                $this->Flash->error(__('Respuesta não inserida. Tente novamente.'));
            }
            // return $this->redirect(['action' => 'index']);
        }
        $questiones = $this->Respostas->Questiones->find()->all();
        $this->set(compact('resposta', 'questiones', 'estagiario_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resposta = $this->Respostas->get($id, [
            'contain' => ['Estagiarios' => ['Alunos']],
        ]);
        $respostas = json_decode($resposta->response, true);
        $avaliacoes = [];
        $i = 0;
        foreach ($respostas as $key => $value) {
            if (substr($key, 0, 9) == 'avaliacao') {
                $pergunta_id = (int) substr($key, 9, 2);
                $pergunta = $this->fetchTable('Questiones')->get(intval($pergunta_id));
                $avaliacoes[$i]['pergunta_id'] = $pergunta_id;    
                $avaliacoes[$i]['pergunta'] = $pergunta->text;
                $avaliacoes[$i]['type'] = $pergunta->type;
                $avaliacoes[$i]['value'] = $value;
                if ($pergunta->type == 'select' || $pergunta->type == 'radio' || $pergunta->type == 'checkbox' || $pergunta->type == 'boolean') {
                    $opcoes = json_decode($pergunta->options, true);
                    $avaliacoes[$i]['opcoes'] = $opcoes;
                } else {
                    $avaliacoes[$i]['opcoes'] = null;
                }
            }
            $i++;
        }
        $this->Authorization->skipAuthorization();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resposta = $this->Respostas->patchEntity($resposta, $this->request->getData());
            $resposta->modified = FrozenTime::now();
            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Resposta atualizada.'));
                return $this->redirect(['action' => 'view', $resposta->id]);
            }
            $this->Flash->error(__('Resposta não atualizada. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $questiones = $this->Respostas->Questiones->find('list', ['limit' => 200])->all();
        $estagiarios = $this->Respostas->Estagiarios->find('list', ['limit' => 200])->all();
        $this->set(compact('resposta', 'avaliacoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resposta = $this->Respostas->get($id);
        $this->Authorization->skipAuthorization();
        if ($this->Respostas->delete($resposta)) {
            $this->Flash->success(__('Resposta excluída.'));
        } else {
            $this->Flash->error(__('Resposta não excluída. Tente novamente.'));
            return $this->redirect(['action' => 'view', $resposta->id]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
