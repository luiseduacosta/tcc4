<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
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
            $query->orderBy(['nome' => 'ASC']);
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
                    $id = $query?->id;
                } else {
                    if ($user->categoria == '3') { // Professor
                        // Se for professor, usa o vínculo do usuário logado
                        // e, na falta dele, procura pelo siape (identificacao)
                        $id = $user->professor_id;
                        if (empty($id) && !empty($user->identificacao)) {
                            $query = $this->Professores->find()
                                ->where(['siape' => $user->identificacao])
                                ->first();
                            $id = $query?->id;
                        }
                    }
                }
            }
            ;
        } else {
            $this->Flash->error(__('Acesso não autorizado para este recurso.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        if ($id === null) {
            $this->Flash->error(__('Nao ha registros de professor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $professor = $this->Professores->get($id);

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
                return $this->redirect(['action' => 'view', $professorcadastrado->id]);
            endif;
        }

        if ($email) {
            $professorcadastrado = $this->Professores->find()
                ->where(['email' => $email])
                ->first();

            if ($professorcadastrado):
                $this->Flash->error(__('E-mail do(a) professor(a) já cadastrado'));
                return $this->redirect(['action' => 'view', $professorcadastrado->id]);
            endif;
        }

        $professor = $this->Professores->newEmptyEntity();
        $this->Authorization->authorize($professor);

        if ($this->request->is('post')) {

            /** Busca se já está cadastrado como user */
            $siape = $this->request->getData('siape');
            $usercadastrado = $this->Professores->Users->find()
                ->where(['categoria' => 3, 'identificacao' => $siape])
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

        $professor = $this->Professores->get($id, contain: [],);
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
            $professor = $this->Professores->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor(a) não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($professor);

        /**
         * Um(a) professor(a) pode estar ligado(a) a uma monografia como
         * orientador(a), coorientador(a) ou membro de banca. Excluir o registro
         * deixaria essas referências órfãs.
         */
        $monografias = $this->Professores->Monografias->find()
            ->where([
                'OR' => [
                    'professor_id' => $professor->id,
                    'num_co_orienta' => $professor->id,
                    'banca1' => $professor->id,
                    'banca2' => $professor->id,
                    'banca3' => $professor->id,
                ],
            ])
            ->count();

        if ($monografias > 0) {
            $this->Flash->error(__('Professor(a) tem {0} monografia(s) associada(s) como orientador(a), coorientador(a) ou membro de banca.', $monografias));
            return $this->redirect(['action' => 'view', $professor->id]);
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
            $professores->orderBy(['nome' => 'ASC']);
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
