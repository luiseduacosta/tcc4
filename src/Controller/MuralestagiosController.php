<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Muralestagios
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Turmaestagios
 * @property \Cake\ORM\TableRegistry $Professores
 * @property \Cake\ORM\TableRegistry $Muralinscricoes
 * @property \Cake\ORM\TableRegistry $Alunos
 * 
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController
{

    /**
     * Initialization method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

    }

    /**
     * Before filter method
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return void
     */
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
    public function index($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $periodo = $this->request->getQuery('periodo');
        if (($periodo == null) || empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotable->find()->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }
        if ($periodo) {
            $muralestagios = $this->Muralestagios->find()
                ->contain(['Instituicoes'])
                ->where([
                    'Muralestagios.periodo' => $periodo
                ])
                ->order(['Muralestagios.dataInscricao' => 'DESC']);
        } else {
            $this->Flash->error(__('Selecionar período.'));
            return $this->redirect(['action' => 'index']);
        }
        /** Todos os períodos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'group' => 'periodo',
            'sort' => ['periodo' => 'DESC']
        ]);
        $periodos = $periodototal->toArray();
        if ($muralestagios->all()->isEmpty()) {
            $this->Flash->warning(__('Nenhum registro de mural de estágio encontrado para o período selecionado.'));
        } else {
            if ($this->request->getQuery('sort') === null) {
                $muralestagios->order(['Muralestagios.dataInscricao' => 'DESC']);
            }
        }
        $mural = $this->paginate($muralestagios, [
            'sortableFields' => ['instituicao', 'vagas', 'beneficios', 'final_de_semana', 'cargaHoraria', 'dataInscricao', 'dataSelecao']
        ]);
        $this->set('muralestagios', $mural);
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
        try {
            $this->Authorization->skipAuthorization();
            $muralestagio = $this->Muralestagios->get($id, [
                'contain' => ['Instituicoes', 'Turmaestagios', 'Professores', 'Muralinscricoes' => ['Alunos', 'Muralestagios']]
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de estagios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        /** Para o administrador selecionar o aluno */
        $alunotable = $this->fetchTable('Alunos');
        $alunos = $alunotable->find('list', [
            'keyField' => 'registro',
            'valueField' => 'nome'
        ]);
        $alunos->order(['nome' => 'ASC']);
        $this->set('alunos', $alunos->toArray());
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
            $configuracaotable = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotable->find()
                ->select(['mural_periodo_atual'])
                ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        $muralestagio = $this->Muralestagios->newEmptyEntity();
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is('post')) {
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
        $instituicoes = $this->fetchTable('Instituicoes')->find('list');
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list');
        $professores = $this->fetchTable('Professores')->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodo'));
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
        try {
            $this->Authorization->skipAuthorization();
            $muralestagio = $this->Muralestagios->get($id, [
                'contain' => ['Instituicoes'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de estagios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        /** Todos os periódos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->Authorization->authorize($muralestagio);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));
                return $this->redirect(['action' => 'view', $muralestagio->id]);
            }
            $erro = $muralestagio->getErrors();
            // pr($erro);
            $this->Flash->error(__('Registro muralestagio não foi atualizado. Tente novamente.'));
        }
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodos'));
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
        try {
            $this->Authorization->skipAuthorization();
            $muralestagio = $this->Muralestagios->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de estagios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is(['post', 'delete'])) {
            if ($this->Muralestagios->delete($muralestagio)) {
                $this->Flash->success(__('Mural de estágio excluído.'));
            } else {
                $this->Flash->error(__('Mural de estágio não foi excluído.'));
                return $this->redirect(['action' => 'view', $muralestagio->id]);
            }
        }
        return $this->redirect(['action' => 'index']);
    }

}
