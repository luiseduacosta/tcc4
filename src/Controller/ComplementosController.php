<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Complementos Controller
 *
 * @property \App\Model\Table\ComplementosTable $Complementos
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Complementos
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * 
 * @method \App\Model\Entity\Complemento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComplementosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $complementos = $this->paginate($this->Complementos);
        $this->Authorization->authorize($this->Complementos);
        $this->set(compact('complementos'));
    }

    /**
     * View method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();  
        try {
            $complemento = $this->Complementos->get($id, [
                'contain' => ['Estagiarios'],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($complemento);
        $this->set(compact('complemento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $complemento = $this->Complementos->newEmptyEntity();
        if ($this->request->is('post')) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Complemento inserido.'));

                return $this->redirect(['action' => 'view', $complemento->id]);
            }
            $this->Flash->error(__('Complemento não inserido.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $complemento = $this->Complementos->get($id, [
                'contain' => [],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($complemento);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Complemento atualizado.'));

                return $this->redirect(['action' => 'view', $complemento->id]);
            }
            $this->Flash->error(__('Complemento não atualizado.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $complemento = $this->Complementos->get($id);
        } catch (\Exception $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($complemento);

        if ($this->request->is(['post', 'delete'])) {
            if ($this->Complementos->delete($complemento)) {
                $this->Flash->success(__('Complemento excluído.'));
            } else {
                $this->Flash->error(__('Complemento não excluído.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}