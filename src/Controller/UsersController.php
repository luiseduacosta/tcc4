<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Users
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Professores
 * @property \Cake\ORM\TableRegistry $Supervisores
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
                $estudante_id = $result->getData()->estudante_id;
                if (empty($estudante_id)) {
                    $estudante = $this->fetchTable('Alunos')->find()
                        ->where(['Alunos.email' => $result->getData()->email])
                        ->first();
                    if (empty($estudante)) {
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $result->getData()->numero, 'email' => $result->getData()->email]]);
                    } else {
                        $user = $this->Users->get($result->getData()->id);
                        $data['estudante_id'] = $estudante->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                        }
                        $estudante_id = $estudante->id;
                    }
                } 
                $controller = 'Alunos';
                $action = 'view';
                $id = $estudante_id;
            }
            elseif ($result->getData()->categoria == '3') {
                $professor_id = $result->getData()->professor_id;
                if (empty($professor_id)) {
                    $professor = $this->fetchTable('Professores')->find()
                        ->where(['Professores.email' => $result->getData()->email])
                        ->first();
                    if (empty($professor)) {
                        return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $result->getData()->numero, 'email' => $result->getData()->email]]);
                    } else {
                        $user = $this->Users->get($result->getData()->id);
                        $data['professor_id'] = $professor->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                        }
                        $professor_id = $professor->id;
                    }
                }
                $controller = 'Professores';
                $action = 'view';
                $id = $professor_id;
            }
            elseif ($result->getData()->categoria == '4') {
                $supervisor_id = $result->getData()->supervisor_id;
                if (empty($supervisor_id)) {
                    $supervisor = $this->fetchTable('Supervisores')->find()
                        ->where(['Supervisores.email' => $result->getData()->email])
                        ->first();
                    // debug($supervisor);
                    // die();
                    if (empty($supervisor)) {
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $result->getData()->numero, 'email' => $result->getData()->email]]);
                    } else {
                        $user = $this->Users->get($result->getData()->id);
                        $data['supervisor_id'] = $supervisor->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                        }
                        $supervisor_id = $supervisor->id;
                    }
                }
                $controller = 'Supervisores';
                $action = 'view';
                $id = $supervisor_id;
            }
            elseif ($result->getData()->categoria == '1') {
                $this->Flash->success(__('Administrador logado com sucesso'));
                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
            } 
            $this->Flash->success(__('Login realizado com sucesso'));
            return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário ou senha inválidos'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
    
    public function logout()
    {
        // In the add, login, and logout methods
        $this->Authorization->skipAuthorization();
        $this->template = 'login';
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Até mais!'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
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
            $this->Flash->error(__('Usuário não autorizado'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
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
        $this->Authorization->skipAuthorization();

        $user = $this->Users->newEmptyEntity();
        // $this->Authorization->authorize($user);
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));
                if ($user->categoria == '2') {
                    $aluno = $this->fetchTable('Alunos')->find()
                    ->where(['Alunos.dre' => $user->numero])
                    ->first();
                    if ($aluno) {
                        $data['estudante_id'] = $aluno->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Associação usuário aluno atualizada.'));
                            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $aluno->id]);
                        } else {
                            $this->Flash->error(__('Erro na associação do aluno ao usuário.'));
                            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                        } 
                    } else {
                        $this->Flash->error(__('Cadastrar aluno.'));
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero, 'email' => $user->email]]);
                    }
                    return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                } elseif ($user->categoria == '3') {
                    $professor = $this->fetchTable('Professores')->find()
                    ->where(['Professores.siape' => $user->numero])
                    ->first();
                    if ($professor) {
                        $data['professor_id'] = $professor->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Associação usuário professor atualizada.'));
                            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professor->id]);
                        } else {
                            $this->Flash->error(__('Erro na associação do professor ao usuário.'));
                            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                        }
                    } else {
                        $this->Flash->error(__('Cadastrar professor.'));
                        return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero, 'email' => $user->email]]);
                    }
                    return $this->redirect(['controller' => 'Professors', 'action' => 'view', $professor->id]);
                } elseif ($user->categoria == '4') {
                    $supervisor = $this->fetchTable('Supervisores')->find()
                    ->where(['Supervisores.cress' => $user->numero])
                    ->first();
                    if ($supervisor) {
                        $data['supervisor_id'] = $supervisor->id;
                        $user = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Associação usuário supervisor atualizada.'));
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]);
                        } else {
                            $this->Flash->error(__('Erro na associação do supervisor ao usuário.'));
                            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                        }
                    } else {
                        $this->Flash->error(__('Cadastrar supervisor.'));
                        return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero, 'email' => $user->email]]);
                    }
                    return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]);
                }
            }
            $this->Flash->error(__('Usúario não foi cadastrado. Tente novamente.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
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
                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('Usuário não atualizado.'));
            return $this->redirect(['action' => 'view', $user->id]);
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
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        } else {
            $this->Flash->error(__('Registro de usuário não excluído.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

}
