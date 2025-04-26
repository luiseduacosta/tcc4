<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        // Permitir aos usuários se registrarem e efetuar logout.
        // Você não deve adicionar a ação de "login" a lista de permissões.
        // Isto pode causar problemas com o funcionamento normal do AuthComponent.
        // $this->Auth->allow(['logout']);
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout']);
    }

    public function login()
    {

        // In the add, login, and logout methods
        $this->Authorization->skipAuthorization();

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // debug($result);
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {

            /**Verifica se o aluno está cadastrado */
            if ($result->getData()->categoria == '2') {
                echo "Estudante";
                $estudante_id = $result->getData()->estudante_id;
                if (empty($estudante_id)) {
                    echo "Estudante não cadastrado";
                    // die();
                    $estudante = $this->fetchTable('Alunos')->find()
                        ->where(['Alunos.email' => $result->getData()->email])
                        ->first();
                    if (empty($estudante)) {
                        echo "Não cadastrado";
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $result->getData()->numero, 'email' => $result->getData()->email]]);
                    } else {
                        $user = $this->Users->get($result->getData()->id);
                        $data['estudante_id'] = $estudante->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                        }
                    }
                }
                // die('Estudante cadastrado');
            }
            // redirect to /monografias after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Alunos',
                'action' => 'view', $result->getData()->estudante_id
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Inválido username ou password'));
        }
    }

    public function logout()
    {

        // In the add, login, and logout methods
        $this->Authorization->skipAuthorization();

        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'monografias', 'action' => 'index']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $user = $this->getRequest()->getAttribute('identity');

        if ($user->categoria == '1'):
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        else:
            $this->redirect(['controller' => 'users', 'action' => 'login']);
            $this->Flash->error(__('Usuário não autorizado'));
        endif;
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($user);
        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        // In the add, login, and logout methods
        $this->Authorization->skipAuthorization();

        $user = $this->Users->newEmptyEntity();
        // $this->Authorization->authorize($user);
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            // pr($this->request->getData());
            // pr($user);
            // die(json_encode($user));
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));

                return $this->redirect(['controller' => 'monografias', 'action' => 'index']);
            }
            $this->Flash->error(__('Usúario não foi cadastrado. Tente novamente.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($user);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Usuário não atualizado.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Registro de usuário excluído.'));
        } else {
            $this->Flash->error(__('Registro de usuário não excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
