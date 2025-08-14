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
        $this->paginate = [
            'contain' => ['Questiones', 'Estagiarios'],
        ];
        $respostas = $this->paginate($this->Respostas);

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
            'contain' => ['Questiones', 'Estagiarios'],
        ]);
        $this->Authorization->skipAuthorization();
        $this->set(compact('resposta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resposta = $this->Respostas->newEmptyEntity();
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $resposta = $this->Respostas->patchEntity($resposta, $this->request->getData());
            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('The resposta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The resposta could not be saved. Please, try again.'));
        }
        $questiones = $this->Respostas->Questiones->find('list', ['limit' => 200])->all();
        $estagiarios = $this->Respostas->Estagiarios->find('list', ['limit' => 200])->all();
        $this->set(compact('resposta', 'questiones', 'estagiarios'));
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
                $this->Flash->success(__('The resposta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The resposta could not be saved. Please, try again.'));
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
            $this->Flash->success(__('The resposta has been deleted.'));
        } else {
            $this->Flash->error(__('The resposta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
