<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        // Permitir aos usuários visitantes possam ver o mural.
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL)
    {

        $this->Authorization->skipAuthorization();
        if (is_null($periodo) || empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracao');
            $periodoconfiguracao = $configuracaotable->find()->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        if ($periodo) {
            $muralestagios = $this->Muralestagios->find('all', [
                'conditions' => ['muralestagios.periodo' => $periodo],
                'order' => ['id' => 'DESC']
            ]);
        } else {
            $muralestagios = $this->Muralestagios->find('all');
        }

        $this->set('muralestagios', $this->paginate($muralestagios));

        /* Todos os periódos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set('periodos', $periodos);
        $this->set('periodo', $periodo);
    }

    /**
     * View method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicoes', 'Turmaestagios', 'Professores', 'Muralinscricoes' => ['Alunos', 'Muralestagios']]
        ]);

        $this->set(compact('muralestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        if (empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracao');
            $periodoconfiguracao = $configuracaotable->find()
                ->select(['mural_periodo_atual'])
                ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        $muralestagio = $this->Muralestagios->newEmptyEntity();
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is('post')) {
            // pr($this->request->getData('instituicao_id'));
            $instituicao = $this->Muralestagios->Instituicoes->find()
                ->where(['id' => $this->request->getData('instituicao_id')])
                ->select(['instituicao'])
                ->first();
            $dados = $this->request->getData();
            if (empty($instituicao['instituicao'])) {
                $this->Flash->error(__('Instituição não encontrada.'));
                return $this->redirect(['action' => 'add']);
            }
            $dados['instituicao'] = $instituicao->instituicao;

            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $dados);
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registo de novo mural de estágio feito.'));

                return $this->redirect(['action' => 'view', $muralestagio->id]);
            }
            $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicoes->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        // pr($professores);
        // die();
        $this->set(compact('muralestagio', 'instituicaoestagios', 'turmaestagios', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        /* Todos os periódos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicoes'],
        ]);
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($muralestagio);
            // pr($this->request->getData());
            // die();
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));

                return $this->redirect(['action' => 'view', $muralestagio->id]);
            }
            // $erro = $muralestagio->getErrors();
            // pr($erro);
            $this->Flash->error(__('Registro muralestagio não foi atualizado. Tente novamente.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicoes->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicaoestagios', 'turmaestagios', 'professores', 'periodos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id);
        $this->Authorization->authorize($muralestagio);

        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('Mural de estágio excluído.'));
        } else {
            $this->Flash->error(__('Mural de estágio não foi excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
