<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        // Permitir aos usuários visitantes possam ver o mural.
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL) {

        $this->Authorization->skipAuthorization();
        if (is_null($periodo) || empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracao');
            $periodoconfiguracao = $configuracaotable->find();
            $periodo = $periodoconfiguracao->first();
            $periodo = $periodo->mural_periodo_atual;
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
    public function view($id = null) {
        // pr($id);
        // die();
        $this->Authorization->skipAuthorization();
        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios', 'Areaestagios', 'Professores', 'Muralinscricoes' => ['Estudantes', 'Muralestagios']]
        ]);
        // pr($muralestagio);
        // die();

        $this->set(compact('muralestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        if (empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracao');
            $periodoconfiguracao = $configuracaotable->find();
            $periodo = $periodoconfiguracao->first();
            $periodo = $periodo->mural_periodo_atual;
        }

        $muralestagio = $this->Muralestagios->newEmptyEntity();
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is('post')) {
            // pr($this->request->getData('instituicaoestagio_id'));
            $instituicaoquery = $this->Muralestagios->Instituicaoestagios->find()
                    ->where(['id' => $this->request->getData('id_estagio')])
                    ->select(['instituicao']);
            $instituicao = $instituicaoquery->first();
            // pr($instituicao);
            $dados = $this->request->getData();
            $dados['instituicao'] = $instituicao->instituicao;
            // pr($dados);
            // die();
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $dados);
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registo de novo mural de estágio feito.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list');
        $areaestagios = $this->Muralestagios->Areaestagios->find('list', ['limit' => 200]);
        $Professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicaoestagios', 'areaestagios', 'Professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $query = $this->Muralestagios->find('all', [
            'fields' => ['periodo'],
            'group' => ['periodo'],
            'order' => ['periodo']
        ]);
        $periodos = $query->all()->toArray();
        foreach ($query as $c_periodo) {
            $periodostotal[$c_periodo->periodo] = $c_periodo->periodo;
        }

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios'],
        ]);
        $this->Authorization->authorize($muralestagio);

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            // $erro = $muralestagio->getErrors();
            // pr($erro);
            $this->Flash->error(__('Registro muralestagio não foi atualizado. Tente novamente.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list');
        $areaestagios = $this->Muralestagios->Areaestagios->find('list', ['limit' => 200]);
        $Professores = $this->Muralestagios->Professores->find('list', ['limit' => 500]);
        $this->set(compact('muralestagio', 'instituicaoestagios', 'areaestagios', 'Professores', 'periodostotal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id);
        $this->Authorization->authorize($muralestagio);

        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('The muralestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The muralestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
