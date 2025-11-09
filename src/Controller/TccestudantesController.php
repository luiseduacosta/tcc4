<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Tccestudantes Controller
 *
 * @property \App\Model\Table\TccestudantesTable $Tccestudantes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Tccestudantes
 * @property \Cake\ORM\TableRegistry $Monografias
 * @property \Cake\ORM\TableRegistry $Estudantes
 * @property \Cake\ORM\TableRegistry $Docentes
 * 
 * @method \App\Model\Entity\Tccestudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * 
 * #[AllowDynamicProperties];
 */

class TccestudantesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $this->Authorization->skipAuthorization();

        if ($this->request->is('post')) {
            if ($this->request->getData()) {
                $dados = $this->request->getData();
                $query = $this->Tccestudantes->find()
                    ->contain(['Monografias'])
                    ->where(['nome LIKE' => "%" . $dados['nome'] . "%"]);
            }
        } else {

            $query = $this->Tccestudantes->find()
                ->contain(['Monografias']);
        }

        if ($query) {
            if ($this->request->getQuery('sort') === null) {
                $query->order('nome');
            }
        } else {
            $this->Flash->error(__('Nenhum registro encontrado.'));
            return $this->redirect(['action' => 'add']);
        }

        $tccestudantes = $this->paginate($query, [
            'sortableFields' => [
                'Tccestudantes.id',
                'Tccestudantes.registro',
                'Tccestudantes.nome',
                'Monografias.titulo'
            ]
        ]);

        $this->set(compact('tccestudantes'));

    }

    /**
     * View method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $tccestudante = $this->Tccestudantes->get($id, [
                'contain' => ['Monografias', 'Estudantes'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->skipAuthorization();
        $this->set('tccestudante', $tccestudante);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($estudante_id = null, $monografia_id = null)
    {

        if ($estudante_id):
            if (strlen($estudante_id) < 9):
                $this->Flash->error(__('Registro inválido.'));
                return $this->redirect(['action' => 'index']);
            endif;
            $registro = $estudante_id;

            /* Nome do aluno */
            $resultado = $this->fetchTable('Estudantes')->find('all');
            $resultado->where(['registro' => $estudante_id]);
            $resultado->select(['nome']);
            $resultado->first();
            $nome = $resultado->nome;
            // die();
            $this->set(compact('registro', 'nome'));
        endif;

        /* Titulo e id das monografias */
        $monografias = $this->Tccestudantes->Monografias->find(
            'list',
            ['keyField' => 'id', 'valueField' => 'titulo']
        );
        $monografias->order(['titulo' => 'asc']);

        $tccestudante = $this->Tccestudantes->newEmptyEntity();
        $this->Authorization->authorize($tccestudante);

        if ($this->request->is('post')) {
            $tccaluno = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            if ($this->Tccestudantes->save($tccaluno)) {
                $this->Flash->success(__('Estudante autor de TCC inserido!'));
                return $this->redirect(['action' => 'view', $tccestudante->id]);
            }
            $this->Flash->error(__('Estudante autor de TCC não foi inserido. Tente novamento.'));
        }
        $estudantes = $this->fetchTable('Estudantes')
            ->find('list')
            ->select(['Estudantes.id', 'Estudantes.nome'])
            ->order(['Estudantes.nome' => 'asc'])
            ->join([
                'table' => 'tccestudantes',
                'alias' => 'Tccestudantes',
                'type' => 'LEFT',
                'conditions' => 'Estudantes.registro = Tccestudantes.registro',
            ]);
        $estudantes->order(['Estudantes.nome' => 'asc']);
        $this->set(compact('monografia_id', 'estudante_id', 'monografias', 'tccestudante', 'estudantes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        try {
            $tccestudante = $this->Tccestudantes->get($id, [
                'contain' => ['Monografias'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($tccestudante);
        $monografias = $this->fetchTable('Monografias')
            ->find('list', ['keyField' => 'id', 'valueField' => 'titulo'])
            ->order(['titulo' => 'asc']);
        $monografias = $monografias->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $tccestudante = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            if ($this->Tccestudantes->save($tccestudante)) {
                $this->Flash->success(__('Estudante de TCC atualizado.'));
                return $this->redirect(['action' => 'view', $tccestudante->id]);
            }
            $this->Flash->error(__('Estudante de TCC não foi atualizado.'));
        }
        $this->set(compact('monografias', 'estudantes', 'tccestudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tccestudante = $this->Tccestudantes->get($id);
        $this->Authorization->authorize($tccestudante);
        if ($this->Tccestudantes->delete($tccestudante)) {
            $this->Flash->success(__('Estudante autor de TCC excluído.'));
        } else {
            $this->Flash->error(__('Estudante autor de TCC não foi excluído.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
