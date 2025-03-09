<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Userestagios Controller
 *
 * @property \App\Model\Table\UserestagiosTable $Userestagios
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserestagiosController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        $this->paginate = [
            'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
        ];
        $userestagios = $this->paginate($this->Userestagios);
        $this->Authorization->authorize($this->Userestagios);
        $this->set(compact('userestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $userestagio = $this->Userestagios->get($id, [
            'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
        ]);
        $this->Authorization->authorize($userestagio);
        $this->set(compact('userestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $this->Authorization->skipAuthorization();
        $userestagio = $this->Userestagios->newEmptyEntity();

        if ($this->request->is('post')) {

            if ($this->request->getData('categoria') == 2):

                $dados = $this->request->getData();
                // pr($dados);
                // die();

                /* Verifico se já está cadastrado */
                $usercadastradoquery = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')]);

                $usercadastrado = $usercadastradoquery->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como estudante */
                $estudantetable = $this->fetchTable('Estudantes');
                $estudantequery = $estudantetable->find()->where(['registro' => $this->request->getData('numero')]);
                $estudantecadastrado = $estudantequery->first();
                // pr($estudantecadastrado);
                // die();
                if ($estudantecadastrado) {
                    $dados['estudante_id'] = $estudantecadastrado->id;
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Estudante de estagio inserido.'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'estudantes', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Usuário de estagio inserido.'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'estudantes', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('O usuário de estagio não foi cadastrado. Tente novamente.'));
            endif;

            if ($this->request->getData('categoria') == 3):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastradoquery = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')]);

                $usercadastrado = $usercadastradoquery->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como docente */
                $docentetable = $this->fetchTable('Docentes');
                $docentequery = $docentetable->find()->where(['siape' => $this->request->getData('numero')]);
                $docentecadastrado = $docentequery->first();
                // pr($docentecadastrado);
                // die();
                if ($docentecadastrado) {
                    $dados['docente_id'] = $docentecadastrado->id;
                    // pr($dados);
                    // die();
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Docente cadastrado.'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Docentes */
                        return $this->redirect(['controller' => 'docentes', 'action' => 'add', '?' => ['siape' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Professora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'docentes', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('Docentes são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;

            if ($this->request->getData('categoria') == 4):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastradoquery = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')]);

                $usercadastrado = $usercadastradoquery->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como supervisor */
                $supervisortable = $this->fetchTable('Supervisores');
                $supervisorquery = $supervisortable->find()->where(['cress' => $this->request->getData('numero')]);
                $supervisorcadastrado = $supervisorquery->first();
                // pr($supervisorcadastrado);
                // die();
                if ($supervisorcadastrado) {
                    $dados['supervisor_id'] = $supervisorcadastrado->id;
                    // pr($dados);
                    // die();
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Supervisor cadastrado.'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Docentes */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['siape' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Supervisora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('id_categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('numero', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }

                $this->Flash->error(__('Supervisores são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;
        }
        $estudantes = $this->Userestagios->Estudantes->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Userestagios->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $userestagio = $this->Userestagios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($userestagio);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userestagio = $this->Userestagios->patchEntity($userestagio, $this->request->getData());
            if ($this->Userestagios->save($userestagio)) {
                $this->Flash->success(__('The userestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
        }
        $estudantes = $this->Userestagios->Estudantes->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Userestagios->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $userestagio = $this->Userestagios->get($id);
        $this->Authorization->authorize($userestagio);
        
        if ($this->Userestagios->delete($userestagio)) {
            $this->Flash->success(__('Usuário excluído.'));
            return $this->redirect(['action' => 'login']);
        } else {
            $this->Flash->error(__('Não foi possível excluir o usuário.'));
            return $this->redirect(['action' => 'login']);
        }
        return $this->redirect(['action' => 'login']);
    }

    public function login() {

        $this->request->allowMethod(['get', 'post']);
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // pr($result);
        // die();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            // pr($this->request->getAttribute('authentication'));
            /* Parece desnecessário fazer isto */
            $dados['id'] = $this->Authentication->getIdentityData('id');
            $dados['id_categoria'] = $this->Authentication->getIdentityData('categoria');
            $dados['numero'] = $this->Authentication->getIdentityData('numero');
            $dados['email'] = $this->Authentication->getIdentityData('email');
            $dados['estudante_id'] = $this->Authentication->getIdentityData('estudante_id');
            $dados['docente_id'] = $this->Authentication->getIdentityData('docente_id');
            $dados['supervisor_id'] = $this->Authentication->getIdentityData('supervisor_id');
            // pr($dados);
            // die();
            switch ($dados['id_categoria']):
                case 1:
                    echo "Administrador";
                    $this->Flash->success(__('Bem-vindo administrador!'));
                    $this->getRequest()->getSession()->write('id_categoria', $dados['id_categoria']);
                    return $this->redirect(__('/muralestagios/index'));
                    break;
                case 2:
                    echo "Estudante";
                    $this->getRequest()->getSession()->write('id_categoria', $dados['id_categoria']);
                    $this->getRequest()->getSession()->write('numero', $dados['numero']);
                    $this->getRequest()->getSession()->write('usuario', $dados['email']);
                    if (empty($dados['estudante_id'])):
                        // echo "Estudante sem o id cadastrado";
                        $userestagios = $this->Userestagios->get($dados['id']);
                        $estudantetable = $this->fetchTable('Estudantes');
                        $estudantecadastrado = $estudantetable->find()->where(['registro' => $dados['numero']])->select(['id']);
                        if ($estudantecadastrado->first()) {
                            $dados['estudante_id'] = $estudantecadastrado->first()->id;
                            $userestagios = $this->Userestagios->patchEntity($userestagios, $dados);
                            if ($this->Userestagios->save($userestagios)) {
                                $this->Flash->success(__('Usuário atualizado!'));
                                return $this->redirect('/muralestagios/index');
                            }
                        } else {
                            return $this->redirect(__('/estudantes/add?registro=' . $dados['numero'] . '&email=' . $dados['email']));
                        }
                    // die();
                    else:
                        $estudantetable = $this->fetchTable('Estudantes');
                        $estudantequery = $estudantetable->find()->where(['registro' => $dados['numero']]);
                        $estudante = $estudantequery->first();
                        /* Se um usuário da categoria estudante e não está cadastrado como estudante então realiza cadastramento */
                        if (empty($estudante)) {
                            return $this->redirect(__('/estudantes/add?registro=' . $dados['numero'] . '&email=' . $dados['email']));
                        } else {
                            $this->Flash->success(__('Bem-vindo estudante!'));
                            /* Verifico se é estagiário capturo o id  e guardo numa varíavel de sessão */
                            $estudantetable = $this->fetchTable('Estagiarios');
                            $estagiarioultimo_id = $estudantetable->find()
                                    ->where(['Estagiarios.registro' => $this->Authentication->getIdentityData('numero')])
                                    ->select(['id'])
                                    ->orderDesc('nivel')
                                    ->first();
                            // pr($estagiarioultimo_id);
                            // die();
                            if ($estagiarioultimo_id) {
                                $this->getRequest()->getSession()->write('estagiario_id', $estagiarioultimo_id->id);
                            } else {
                                $this->getRequest()->getSession()->delete('estagiario_id');
                                $this->Flash->success(__('Estudante sem estágio'));
                            }
                            /* Agora sim vou para o mural de estágios */
                            $redirect = $this->request->getQuery('redirect', [
                                'controller' => 'muralestagios',
                                'action' => 'index',
                            ]);
                        }
                    endif;
                    break;
                case 3:
                    echo "Professor";

                    /* Verifico se está cadastrado como docente */
                    $docentetable = $this->fetchTable('Docentes');
                    $docentequery = $docentetable->find()
                            ->contain(['Estagiarios'])
                            ->where(['siape' => $dados['numero']]);
                    $docente = $docentequery->first();
                    if (!$docente) {
                        // echo "Docente sem cadastrado";
                        return $this->redirect(__('/docentes/add?siape=' . $dados['numero']));
                    }
                    if ($docente->has('estagiarios')) {
                        $this->getRequest()->getSession()->write('estagiario', 1);
                    } else {
                        $this->getRequest()->getSession()->delete('estagiario');
                    }
                    // die('Professor');

                    /* Verifico ainda se o campo docente_id está preenchido */
                    if (empty($dados['docente_id'])):
                        // echo "Docente não cadastrado";
                        return $this->redirect('/docentes/add?siape=' . $dados['numero']);
                    else:

                        $this->getRequest()->getSession()->write('id_categoria', $dados['id_categoria']);
                        $this->getRequest()->getSession()->write('numero', $dados['numero']);
                        $this->getRequest()->getSession()->write('usuario', $dados['email']);

                        $this->Flash->success(__('Bem-vinda(o) professora(o)!'));
                        return $this->redirect('/muralestagios/index');
                    endif;
                    break;
                case 4:
                    echo "Supervisor";
                    // die();
                    if (empty($dados['supervisor_id'])):
                        // echo "Supervisor não cadastrado";
                        return $this->redirect('/supervisores/add?cress=' . $dados['numero']);
                    else:

                        $this->getRequest()->getSession()->write('id_categoria', $dados['id_categoria']);
                        $this->getRequest()->getSession()->write('numero', $dados['numero']);
                        $this->getRequest()->getSession()->write('usuario', $dados['email']);

                        $this->Flash->success(__('Bem-vinda(o) supervisora(o)!'));
                        return $this->redirect('/muralestagios/index');
                    endif;

                    break;
                default:
                    echo "Sem categorizar";
                    $this->Flash->error(__('Usuário não categorizado em nenhum segmento'));
                    return $this->redirect('/userestagios/logout');
            endswitch;
            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário e/ou senha errado'));
        }
    }

    public function logout() {
        
        $this->Authorization->skipAuthorization();        
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();

            $this->getRequest()->getSession()->delete('id_categoria');
            $this->getRequest()->getSession()->delete('numero');
            $this->getRequest()->getSession()->delete('usuario');
            $this->getRequest()->getSession()->delete('estagiario_id');

            return $this->redirect(['controller' => 'userestagios', 'action' => 'login']);
        }
    }

    /*
     * Preenche os ids da tabela userestagios com os valores correspondentes
     */

    public function preencher() {

        $this->Authorization->skipAuthorization();
        $user = $this->Userestagios->find('all');
        foreach ($user as $c_user) {
            // pr($c_user->categoria);
            if ($c_user->categoria == 2) {
                // pr($c_user->numero);
                $estudantetable = $this->fetchTable('Estudantes');
                $estudante = $estudantetable->find()
                        ->contain([])
                        ->where(['estudantes.registro' => $c_user->numero]);
                // pr($estudante);
                // pr($estudante->first()->registro);
                $c_user->estudante_id = $estudante->first()->id;
                // pr($c_user->estudante_id);
                // pr($c_user->id);
                if ($this->Userestagios->save($c_user)) {
                    // echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    // echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die();
            }
            // die('Estudantes');
            // Professores
            if ($c_user->categoria == 3) {
                // pr($c_user->numero);
                // die();
                $docentetable = $this->loadMode('Docentes');
                $docente = $this->Docentes->find()
                        ->contain([])
                        ->where(['docentes.siape' => $c_user->numero]);
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->docente_id = $docente->first()->id;
                // pr($c_user->docente_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if docentes');
            }
            // die('Docentes');
            // Supervisores
            if ($c_user->categoria == 4) {
                // pr($c_user->numero);
                // die();
                $supervisorestable = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestable->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->numero]);
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->supervisor_id = $supervisor->first()->id;
                // pr($c_user->docente_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if docentes');
            }
            // die('Docentes');
        }
        // pr($user);
        die();
    }

}
