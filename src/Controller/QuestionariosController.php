<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Questionarios Controller
 *
 * @property \App\Model\Table\QuestionariosTable $Questionarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionariosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $questionarios = $this->paginate($this->Questionarios);

        $this->set(compact('questionarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questionario = $this->Questionarios->get($id, [
            'contain' => ['Questiones'],
        ]);
        $this->Authorization->skipAuthorization();
        $this->set(compact('questionario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionario = $this->Questionarios->newEmptyEntity();
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário inserido.'));
                return $this->redirect(['action' => 'view', $questionario->id]);
            }
            $this->Flash->error(__('Questionário não inserido. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('questionario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questionario = $this->Questionarios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->skipAuthorization();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário atualizado.'));
                return $this->redirect(['action' => 'view', $questionario->id]);
            }
            $this->Flash->error(__('Questionário não atualizado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('questionario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $questionario = $this->Questionarios->get($id);
        $this->Authorization->skipAuthorization();
        if ($this->Questionarios->delete($questionario)) {
            $this->Flash->success(__('Questionário excluído.'));
        } else {
            $this->Flash->error(__('Questionário não excluído. Tente novamente.'));
            return $this->redirect(['action' => 'view', $questionario->id]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
