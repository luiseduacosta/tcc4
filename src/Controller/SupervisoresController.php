<?php

declare(strict_types=1);
namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Professores
 * 
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $supervisores = $this->paginate($this->Supervisores);
        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $this->Authorization->skipAuthorization();
        if ($id === null):
            $cress = $this->getRequest()->getQuery('cress');
            $supervisorquery = $this->Supervisores->find()
                ->where(['cress' => $cress]);
            $supervisor = $supervisorquery->first();
            $id = $supervisor->id;
        endif;

        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicoes' => ['Areainstituicoes'], 'Estagiarios' => ['Alunos', 'Supervisores', 'Professores', 'Instituicoes']],
        ]);
        // pr($supervisor);
        // die();
        // $this->Authorization->authorize($supervisor);
        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $supervisor = $this->Supervisores->newEmptyEntity();
        $this->Authorization->authorize($supervisor);

        if ($this->request->is('post')) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Registro de supervisora realizado.'));
                return $this->redirect(['action' => 'view', $supervisor->id]);
            }
            $this->Flash->error(__('O registro da supervisora não foi realizado. Tente novamente.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicoes'],
        ]);
        $this->Authorization->authorize($supervisor);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Supervisora atualizada .'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('A supervisora não foi atualizada. Tente novamente.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $supervisor = $this->Supervisores->get($id);
        $this->Authorization->authorize($supervisor);

        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('Registro de supervisor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro de supervisor(a) não excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
