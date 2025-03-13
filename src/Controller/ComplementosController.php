<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Complementos Controller
 *
 * @property \App\Model\Table\ComplementosTable $Complementos
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
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
        $complemento = $this->Complementos->get($id, [
            'contain' => ['Estagiarios'],
        ]);
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
        $complemento = $this->Complementos->newEmptyEntity();
        $this->Authorization->authorize($complemento);        
        if ($this->request->is('post')) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('The complemento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The complemento could not be saved. Please, try again.'));
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
        $complemento = $this->Complementos->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($complemento);        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('The complemento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The complemento could not be saved. Please, try again.'));
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
        $this->request->allowMethod(['post', 'delete']);
        $complemento = $this->Complementos->get($id);
        $this->Authorization->authorize($complemento);
        if ($this->Complementos->delete($complemento)) {
            $this->Flash->success(__('The complemento has been deleted.'));
        } else {
            $this->Flash->error(__('The complemento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
