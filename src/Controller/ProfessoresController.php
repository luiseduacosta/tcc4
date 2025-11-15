<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Professores
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * 
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authorization.Authorization');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Professores->find('all');
        if (!$query) {
            $this->Flash->error(__('Nenhum(a) professor(a) encontrado.'));
            return $this->redirect(['action' => 'add']);
        }
        if ($this->request->getQuery('sort') === null) {
            $query->order(['nome' => 'ASC']);
        }
        $professores = $this->paginate($query, [
            'sortableFields' => ['nome', 'siape', 'departamento', 'dataingresso', 'dataegresso']
        ]);
        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Authentication->getIdentity();
        if (isset($user) && ($user->categoria == '1' || $user->categoria == '3')) {
            if ($id === null) {
                $siape = $this->getRequest()->getQuery('siape');
                if (isset($siape)) {
                    $query = $this->Professores->find()
                        ->where(['siape' => $siape])
                        ->first();
                    $id = $query->id;
                } else {
                    if ($user->categoria == '3') { // Professor
                        // Se for professor, pega o siape do usuário logado
                        // e busca o professor correspondente
                        $siape = $user->numero;
                        if (isset($siape)) {
                            $query = $this->Professores->find()
                                ->where(['siape' => $siape])
                                ->first();
                            $id = $query->id;
                        }
                    }
                }
            }
            ;
        } else {
            $this->Flash->error(__('Acesso não autorizado para este recurso.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        /** Têm Professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');
        $professor = $this->Professores->get(
            $id,
            [
                'contain' => ['Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Instituicoes', 'Supervisores', 'Professores', 'Alunos']]
            ]
        );

        if (!isset($professor)) {
            $this->Flash->error(__('Nao ha registros de professor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('professor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $siape = $this->getRequest()->getQuery('siape');
        $email = $this->getRequest()->getQuery('email');

        /** Para o formulário */
        if ($siape):
            $this->set('siape', $siape);
        endif;

        if ($email):
            $this->set('email', $email);
        endif;

        /* Verifico se já está cadastrado */
        if ($siape) {
            $professorcadastrado = $this->Professores->find()
                ->where(['siape' => $siape])
                ->first();

            if ($professorcadastrado):
                $this->Flash->error(__('Siape do(a) professor(a) já cadastrado'));
                return $this->redirect(['view' => $professorcadastrado->id]);
            endif;
        }

        if ($email) {
            $professorcadastrado = $this->Professores->find()
                ->where(['email' => $email])
                ->first();

            if ($professorcadastrado):
                $this->Flash->error(__('E-mail do(a) professor(a) já cadastrado'));
                return $this->redirect(['view' => $professorcadastrado->id]);
            endif;
        }

        $professor = $this->Professores->newEmptyEntity();
        $this->Authorization->authorize($professor);

        if ($this->request->is('post')) {

            /** Busca se já está cadastrado como user */
            $siape = $this->request->getData('siape');
            $usercadastrado = $this->Professores->Users->find()
                ->where(['categoria' => 3, 'numero' => $siape])
                ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Professor(a) não cadastrado(a) como usuário(a)'));
                // return $this->redirect('/users/add'); // Não é obrigatório cadastrar como usuário
            endif;

            $professorresultado = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professorresultado)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));
                return $this->redirect(['action' => 'view', $professorresultado->id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));
            if ($siape && $email):
                return $this->redirect(['action' => 'add', '?' => ['siape' => $siape, 'email' => $email]]);
            else:
                return $this->redirect(['action' => 'add']);
            endif;
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $professor = $this->Professores->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($professor);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->Authorization->skipAuthorization();
        try {
            $professor = $this->Professores->get($id, [
                'contain' => ['Estagiarios']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor(a) não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($professor);
        if (sizeof($professor->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $id]);
        }

        if ($this->request->is(['post', 'delete'])) {  
            if ($this->Professores->delete($professor)) {
                $this->Flash->success(__('Registro professor(a) excluído.'));
            } else {
                $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    public function buscaprofessor($nome = null)
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->getRequest()->getData('nome');
        if ($nome) {
            $professores = $this->Professores->find('all');
            $professores->where(['nome LIKE' => "%{$nome}%"]);
            $professores->order(['nome' => 'ASC']);
            if (!$professores->toArray()) {
                $this->Flash->error(__('Nenhum(a) professor(a) encontrado com o nome: ' . $nome));
                return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
            }
            $professores = $this->paginate($professores);
            $this->set('professores', $professores);
            $this->render('index');
        } else {
            $this->Flash->error(__('Digite um nome para buscar'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
        }
    }
}
