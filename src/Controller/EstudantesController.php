<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estudantes Controller
 *
 * @property \App\Model\Table\EstudantesTable $Estudantes
 *
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstudantesController extends AppController {

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

        $alunos = $this->paginate($this->Estudantes, ['order' => ['nome' => 'asc']]);
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

        $alunos = $this->paginate($this->Estudantes, ['order' => ['registro' => 'asc']]);
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

        $alunos = $this->paginate($this->Estudantes, ['order' => ['registro' => 'asc']]);
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
        $aluno = $this->Estudantes->get($id, [
            'contain' => [],
        ]);

        $this->set('aluno', $aluno);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $estudante = $this->Estudante->newEmptyEntity();
        $this->Authorization->authorize($estudante);

        if ($this->request->is('post')) {
            $estudante = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Estudante registrado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível registrar o estudante. Tente novamente.'));
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

        $estudante = $this->Estudantes->get($id, [
            'contain' => [],
        ]);
        // pr($estudante);
        // pr($this->request->getData());
        // die();
        // $this->Authorization->authorize($estudante);
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudanteatualiza = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            // debug($estudanteatualiza);
            if ($this->Estudantes->save($estudanteatualiza)) {
                $this->Flash->success(__('Estudante atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Estudante não foi atualizado.'));
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
        $this->loadModel('Estudantes');
        $estudante = $this->Estudantes->get($id);
        $this->Authorization->authorize($estudante);
        if ($this->Estudantes->delete($estudante)) {
            $this->Flash->success(__('The aluno has been deleted.'));
        } else {
            $this->Flash->error(__('Registro de estudante não foi excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
