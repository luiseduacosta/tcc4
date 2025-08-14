<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Questiones Controller
 *
 * @property \App\Model\Table\QuestionesTable $Questiones
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionesController extends AppController
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
            'contain' => ['Questionarios'],
        ];
        $questiones = $this->paginate($this->Questiones);

        $this->set(compact('questiones'));
    }

    /**
     * View method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questione = $this->Questiones->get($id, [
            'contain' => ['Questionarios'],
        ]);
        $this->Authorization->skipAuthorization();
        $this->set(compact('questione'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questione = $this->Questiones->newEmptyEntity();
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $questione = $this->Questiones->patchEntity($questione, $this->request->getData());
            if ($this->Questiones->save($questione)) {
                $this->Flash->success(__('The questione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The questione could not be saved. Please, try again.'));
        }
        $questionarios = $this->Questiones->Questionarios->find('list', ['limit' => 200])->all();
        $this->set(compact('questione', 'questionarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questione = $this->Questiones->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->skipAuthorization();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questione = $this->Questiones->patchEntity($questione, $this->request->getData());
            if ($this->Questiones->save($questione)) {
                $this->Flash->success(__('The questione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The questione could not be saved. Please, try again.'));
        }
        $questionarios = $this->Questiones->Questionarios->find('list', ['limit' => 200])->all();
        $this->set(compact('questione', 'questionarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $questione = $this->Questiones->get($id);
        $this->Authorization->skipAuthorization();
        if ($this->Questiones->delete($questione)) {
            $this->Flash->success(__('The questione has been deleted.'));
        } else {
            $this->Flash->error(__('The questione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
