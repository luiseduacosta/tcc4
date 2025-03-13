<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estudantemonografias Controller
 *
 * @property \App\Model\Table\EstudantemonografiasTable $Estudantemonografias
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *
 * @method \App\Model\Entity\Estudantemonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstudantemonografiasController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        // Permitir aos usuários se registrarem e efetuar logout.
        // Você não deve adicionar a ação de "login" a lista de permissões.
        // Isto pode causar problemas com o funcionamento normal do AuthComponent.
        // $this->Auth->allow(['logout']);
        $this->Authentication->addUnauthenticatedActions(['index', 'index1', 'index2', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $this->Authorization->skipAuthorization();

        $parameters = $this->request->getQueryParams();
        if (isset($parameters) && !empty($parameters)):
            // pr($parameters);
            if (isset($parameters['page'])):
                $pagina = $parameters['page'];
            endif;
            if (isset($parameters['sort'])):
                $ordem = $parameters['sort'];
            endif;
            if (isset($parameters['direction'])):
                $direcao = $parameters['direction'];
            endif;
        else:
            $ordem = 'nome';
            $direcao = 'asc';
        endif;

        $alunos = $this->paginate($this->Estudantemonografias, ['order' => ['nome' => 'asc']]);
        $this->set(compact('alunos'));
    }

    /**
     * Index2 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index1() {

        $this->Authorization->skipAuthorization();

        $parameters = $this->request->getQueryParams();
        if (isset($parameters) && !empty($parameters)):
            // pr($parameters);
            if (isset($parameters['page'])):
                $pagina = $parameters['page'];
            endif;
            if (isset($parameters['sort'])):
                $ordem = $parameters['sort'];
            endif;
            if (isset($parameters['direction'])):
                $direcao = $parameters['direction'];
            endif;
        else:
            $ordem = 'nome';
            $direcao = 'asc';
        endif;

        $alunos = $this->paginate($this->Estudantemonografias, ['order' => ['registro' => 'asc']]);
        $this->set(compact('alunos'));
    }

    /**
     * Index2 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index2() {

        $this->Authorization->skipAuthorization();

        $parameters = $this->request->getQueryParams();
        if (isset($parameters) && !empty($parameters)):
            // pr($parameters);
            if (isset($parameters['page'])):
                $pagina = $parameters['page'];
            endif;
            if (isset($parameters['sort'])):
                $ordem = $parameters['sort'];
            endif;
            if (isset($parameters['direction'])):
                $direcao = $parameters['direction'];
            endif;
        else:
            $ordem = 'nome';
            $direcao = 'asc';
        endif;

        $alunos = $this->paginate($this->Estudantemonografias, ['order' => ['registro' => 'asc']]);
        $this->set(compact('alunos'));
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();

        $tccestudantetable = $this->fetchTable('Tccestudantes');
        $tccestudantequery = $tccestudantetable->find()->select(['registro'])->where(['id' => $id]);
        $tccestudante = $tccestudantequery->first();

        if ($tccestudante):
            $query = $this->Estudantemonografias->find()
                    ->where(['registro' => $tccestudante->registro]);
            $aluno = $query->first();
            if (empty($aluno)):
                $this->Flash->error(__('Não há estudante cadastrado'));
                return $this->redirect(['controller' => 'tccestudantes', 'action' => 'view', $id]);
            endif;
        else:
            $this->Flash->error(__('Não há estudante cadastrado'));
            return $this->redirect(['controller' => 'tccestudantes', 'action' => 'view', $id]);
        endif;
        $this->set('aluno', $aluno);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $estudantetable = $this->fetchTable('Estudantemonografias');
        $estudante = $estudantetable->newEmptyEntity();
        $this->Authorization->authorize($estudante);

        if ($this->request->is('post')) {
            $estudante = $this->Estudantemonografias->patchEntity($estudante, $this->request->getData());
            if ($this->Estudantemonografias->save($estudante)) {
                $this->Flash->success(__('Registro adicionado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro não foi adicionado. Tente novamente.'));
        }
        $this->set(compact('estudante'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $estudante = $this->Estudantemonografias->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estudante);
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudanteatualiza = $this->Estudantemonografias->patchEntity($estudante, $this->request->getData());
            // debug($estudanteatualiza);
            if ($this->Estudantemonografias->save($estudanteatualiza)) {
                $this->Flash->success(__('The aluno has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $this->set(compact('estudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $estudante = $this->Estudantemonografias->get($id);
        $this->Authorization->authorize($estudante);
        if ($this->Estudantemonografias->delete($estudante)) {
            $this->Flash->success(__('The aluno has been deleted.'));
        } else {
            $this->Flash->error(__('The aluno could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
