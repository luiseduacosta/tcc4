<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use phpDocumentor\Reflection\Types\Null_;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['view', 'index', 'indexold', 'busca', 'registro']);

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function indexold()
    {
        // echo "index" . "<br>";
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'conditions' => ['nivel' => 4],
            'contain' => ['Tccestudantes', 'Estudantes'],
        ];
        $estagiarios = $this->paginate($this->Estagiarios);
        // pr($estagiarios);
        $this->set(compact('estagiarios'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        // $periodo = $this->getRequest()->getQuery('periodo');
        $data = $this->getRequest()->getData();
        if ($data) {
            $periodo = $data['periodo'];
        }
        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracao');
            $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        if ($periodo) {
            $query = $this->Estagiarios->find('all')
                ->where(['Estagiarios.periodo' => $periodo, 'Estagiarios.nivel' => '4'])
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios', 'Tccestudantes']);
        } else {
            $query = $this->Estagiarios->find('all')
                ->where(['nivel' => '4'])
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios', 'Tccestudantes']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome']];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set(compact('estagiarios', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $this->Authorization->skipAuthorization();
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Alunos', 'Professores'],
        ]);

        $this->set('estagiario', $estagiario);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $estagiario = $this->Estagiarios->newEmptyEntity();
        $this->Authorization->authorize($estagiario);
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Estagiário inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Estagiário não foi inserido. Tente novamente.'));
        }
        $estudantes = $this->Estagiarios->Alunos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $supervisores = $this->Estagiarios->Supervisores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $instituicoes = $this->Estagiarios->Instituicoes->find('list', [
            'keyField' => 'id',
            'valueField' => 'instituicao',
            'order' => 'instituicao',
            'limit' => 200
        ]);

        $professores = $this->Estagiarios->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $this->set(compact('estagiario', 'estudantes', 'professores', 'supervisores', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        // $this->autoRender = false;
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estagiario);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Estagiário atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Estagiário não atualizado. Tente novamente.'));
        }
        $estudantes = $this->Estagiarios->Alunos->find(
            'list',
            [
                'keyField' => 'id',
                'valueField' => 'nome'
            ]
        );

        $Professores = $this->Estagiarios->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $this->set(compact('estagiario', 'estudantes', 'Professores', 'areas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        $this->Authorization->authorize($estagiario);

        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Estagiario excluído.'));
        } else {
            $this->Flash->error(__('Estagiário não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function busca($busca = null)
    {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        if ($busca):
            echo "Buscar: " . $busca . "<br>";
        else:
            echo 'Digitar a busca';
        endif;
        // die();
    }

    public function registro($id = null)
    {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;

        if ($this->request->is('ajax')):
            $this->autoRender = false;
            $dre = $this->Estagiarios->get($id);
            $registro = $dre->registro;
            if ($registro):
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(
                        json_encode([
                            'registro' => $registro
                        ])
                    );
            endif;
        endif;
    }
}
