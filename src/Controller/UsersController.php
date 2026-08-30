<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Users Controller
 *
 * A tabela `users` é compartilhada pelas aplicações do ess_apps. O tcc5 usa
 * apenas os perfis estudante (categoria 2) e professor(a) (categoria 3);
 * `supervisor_id` é preservado porque o mural5 depende dele.
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
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
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            /** @var \App\Model\Entity\User $identity */
            $identity = $result->getData();

            $controller = 'Monografias';
            $action = 'index';
            $id = null;

            /**Verifica se o aluno está cadastrado */
            switch ($identity->categoria) {
                case '2':
                    $aluno_id = $identity->aluno_id;
                    if (empty($aluno_id)) {
                        $estudante = $this->fetchTable('Estudantes')->find()
                            ->where(['Estudantes.email' => $identity->email])
                            ->first();
                        if (empty($estudante)) {
                            $this->Flash->error(__('Aluno não encontrado. Por favor, cadastre-se.'));

                            return $this->redirect(['controller' => 'Estudantes', 'action' => 'add', '?' => ['dre' => $identity->identificacao, 'email' => $identity->email]]);
                        } else {
                            $user = $this->Users->get($identity->id);
                            $data['aluno_id'] = $estudante->id;
                            $user = $this->Users->patchEntity($user, $data);
                            if ($this->Users->save($user)) {
                                $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                            }
                            $aluno_id = $estudante->id;
                        }
                    } else {
                        $estudante = $this->fetchTable('Estudantes')->find()
                            ->where(['Estudantes.id' => $aluno_id])
                            ->first();
                        if (empty($estudante)) {
                            $this->Flash->error(__('Aluno não encontrado. Por favor, cadastre-se.'));

                            return $this->redirect(['controller' => 'Estudantes', 'action' => 'add', '?' => ['dre' => $identity->identificacao, 'email' => $identity->email]]);
                        } else {
                            $user = $this->Users->get($identity->id);
                            $data['identificacao'] = $estudante->registro;
                            $data['aluno_id'] = $estudante->id;
                            $user = $this->Users->patchEntity($user, $data);
                            if ($this->Users->save($user)) {
                                $this->Flash->success(__('Registro do(a) usuário(a) atualizado.'));
                            }
                            $controller = 'Estudantes';
                            $action = 'view';
                            $id = $aluno_id;
                        }
                    }
                    break;

                case '3':
                    $professor_id = $identity->professor_id;
                    if (empty($professor_id)) {
                        $professor = $this->fetchTable('Professores')->find()
                            ->where(['Professores.email' => $identity->email])
                            ->first();
                        if (empty($professor)) {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $identity->identificacao, 'email' => $identity->email]]);
                        } else {
                            $user = $this->Users->get($identity->id);
                            $data['professor_id'] = $professor->id;
                            $data['identificacao'] = $professor->siape;
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
                    break;

                case '4':
                    /**
                     * Supervisor(a) de estágio: o cadastro e a área desse perfil
                     * pertencem ao mural5. O tcc5 preserva `supervisor_id` mas não
                     * tem tela para esse perfil, então encerra a sessão para não
                     * entrar em laço de redirecionamento.
                     */
                    $this->Authentication->logout();
                    $this->Flash->error(__('Supervisores(as) de estágio não têm acesso ao sistema de TCC.'));

                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);

                case '1':
                    $this->Flash->success(__('Administrador logado com sucesso'));

                    return $this->redirect(['controller' => 'Monografias', 'action' => 'index']);

                default:
                    $this->Authentication->logout();
                    $this->Flash->error(__('Categoria inválida.'));

                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
            $this->Flash->success(__('Login realizado com sucesso'));

            return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post')) {
            $this->Flash->error(__('Usuário ou senha inválidos'));

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function logout()
    {
        // In the add, login, and logout methods
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setTemplate('login');
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
    public function index(): ?Response
    {
        $this->Authorization->skipAuthorization();

        $user = $this->getRequest()->getAttribute('identity');

        if ($user->categoria == '1') :
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        else :
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
    public function view(?string $id = null): ?Response
    {

        $user = $this->Users->get($id, contain: []);
        $this->Authorization->authorize($user);
        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $this->Authorization->skipAuthorization();

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));
                switch ($user->categoria) {
                    case '2':
                        $estudante = null;
                        if (!empty($user->identificacao)) {
                            $estudante = $this->fetchTable('Estudantes')->find()
                                ->where(['Estudantes.registro' => $user->identificacao])
                                ->first();
                        }
                        if ($estudante) {
                            $data['aluno_id'] = $estudante->id;
                            $user = $this->Users->patchEntity($user, $data);
                            if ($this->Users->save($user)) {
                                $this->Flash->success(__('Associação usuário aluno atualizada.'));

                                return $this->redirect(['controller' => 'Estudantes', 'action' => 'view', $estudante->id]);
                            } else {
                                $this->Flash->error(__('Erro na associação do aluno ao usuário.'));

                                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                            }
                        } else {
                            $this->Flash->error(__('Ingresse para continuar com o cadastro do(a) aluno(a).'));

                            return $this->redirect(['controller' => 'Estudantes', 'action' => 'add', '?' => ['dre' => $user->identificacao, 'email' => $user->email]]);
                        }

                    case '3':
                        $professor = null;
                        if (!empty($user->identificacao)) {
                            $professor = $this->fetchTable('Professores')->find()
                                ->where(['Professores.siape' => $user->identificacao])
                                ->first();
                        }
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
                            $this->Flash->error(__('Ingresse para continuar com o cadastro do(a) professor(a).'));

                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->identificacao, 'email' => $user->email]]);
                        }

                    case '4':
                        /**
                         * O usuário(a) foi cadastrado(a) na tabela compartilhada e
                         * serve ao mural5, mas o cadastro de supervisor(a) e a
                         * associação de `supervisor_id` são feitos naquela aplicação.
                         */
                        $this->Flash->error(__('Complete o cadastro de supervisor(a) no sistema de estágios.'));

                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);

                    default:
                        $this->Flash->error(__('Categoria inválida.'));

                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }
            } else {
                $this->Flash->error(__('Usúario não foi cadastrado. Tente novamente.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
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
    public function edit(?string $id = null): ?Response
    {

        $user = $this->Users->get($id, contain: []);
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
    public function delete(?string $id = null): ?Response
    {

        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de usuário não encontrado.'));

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $this->Authorization->authorize($user);

        if ($this->request->is(['post', 'delete'])) {
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('Registro de usuário excluído.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            } else {
                $this->Flash->error(__('Registro de usuário não excluído.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }
    }
}
