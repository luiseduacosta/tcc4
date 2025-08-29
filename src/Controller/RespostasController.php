<?php
declare(strict_types=1);

namespace App\Controller;

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
        $this->Authorization->skipAuthorization();
        $this->set(compact('resposta'));
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
            $data['created'] = date('Y-m-d H:i:s');
            $data['modified'] = date('Y-m-d H:i:s');
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
            'contain' => [],
        ]);
        $this->Authorization->skipAuthorization();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resposta = $this->Respostas->patchEntity($resposta, $this->request->getData());
            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Resposta atualizada.'));
                return $this->redirect(['action' => 'view', $resposta->id]);
            }
            $this->Flash->error(__('Resposta não atualizada. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $questiones = $this->Respostas->Questiones->find('list', ['limit' => 200])->all();
        $estagiarios = $this->Respostas->Estagiarios->find('list', ['limit' => 200])->all();
        $this->set(compact('resposta', 'questiones', 'estagiarios'));
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
