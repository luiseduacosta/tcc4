<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Muralinscricoes Controller
 *
 * @property \App\Model\Table\MuralinscricoesTable $Muralinscricoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Muralinscricoes
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Muralestagios
 * @property \Cake\ORM\TableRegistry $Instituicoes
 *
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralinscricoesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL)
    {
        if (empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracao');
            $periodoconfiguracao = $configuracaotable->get(1);
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        if ($periodo) {
            $query = $this->Muralinscricoes->find('all')
                ->contain(['Alunos', 'Muralestagios'])
                ->order(['Alunos.nome'])
                ->where(['Muralinscricoes.periodo' => $periodo]);
        } else {
            $query = $this->Muralinscricoes->find('all')
                ->contain(['Alunos', 'Muralestagios'])
                ->order(['Alunos.nome']);
        }
        $this->Authorization->skipAuthorization();
        $muralinscricoes = $this->paginate($query, [
            'sortableFields' => ['id', 'registro', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp']
        ]);

        $periodototal = $this->Muralinscricoes->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set(compact('muralinscricoes', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            $muralinscricao = $this->Muralinscricoes->get($id, [
                'contain' => ['Alunos', 'Muralestagios' => ['Instituicoes']]
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de inscrições para esse número!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        $this->set(compact('muralinscricao'));
    }

    /**
     * Add method
     * 
     * @param string|null $id Muralestagio id.
     * @param string|null $registro Registro dre.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL, $registro = NULL)
    {
        $this->Authorization->skipAuthorization();
        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();
        $this->Authorization->authorize($muralinscricao);

        if ($this->request->is('post', 'put', 'patch')) {
            // Pega os dados do formulário
            if ($this->request->getData('aluno_id')) {
                $aluno = $this->fetchTable('Alunos')->get($this->request->getData('aluno_id'));
                $registro = $aluno->registro;
            } elseif ($this->request->getData('registro')) {
                $registro = $this->request->getData('registro');
            }
            if (empty($registro)) {
                $this->Flash->error(__('Precisa do DRE do estudante para fazer inscrição'));
                return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
            }

            $muralestagio_id = $this->request->getData('muralestagio_id');
            if (empty($muralestagio_id)) {
                $this->Flash->error(__('Selecionar um mural de estágio para a qual quer fazer inscrição.'));
                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
            } else {
                $muralestagio = $this->Muralinscricoes->Muralestagios->get($muralestagio_id);
                if (empty($muralestagio)) {
                    $this->Flash->error(__('Mural de estágio não localizado'));
                } else {
                    $periodo_mural = $muralestagio->periodo;
                }
            }

            $user = $this->request->getAttribute('identity')->getOriginalData();
            $hoje = FrozenTime::now();
            if (empty($muralestagio->dataInscricao)) { 
                $muralestagio->dataInscricao = $hoje->addDays(1);
            }
            /** Verifica se o período de inscrição está aberto */
            if ($user->categoria == 2 && $muralestagio->dataInscricao < $hoje) {
                $this->Flash->error(__('Período de inscrição encerrado em {0}. Não é possível fazer inscrição.', $muralestagio->dataInscricaoo));
                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
            }
            /** Verifica se já fez inscricações para essa mesma vaga de estágio */
            $verifica = $this->Muralinscricoes->find()
                ->where(['muralestagio_id' => $muralestagio_id, 'registro' => $registro])
                ->select(['id'])
                ->first();

            if ($verifica) {
                $this->Flash->error(__('Inscrição já realizada'));
                return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $verifica->id]);
            }

            /** Pega o id do aluno */
            $aluno = $this->fetchTable('Alunos')->find()
                ->where(['registro' => $registro])
                ->select(['id'])
                ->first();
            if (!$aluno) {
                $this->Flash->error(__('Aluno não localizado'));
                return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
            }

            /** Pega o período atual */
            $periodo = $this->fetchTable('Configuracao')->get(1);
            $periodo_atual = $periodo->mural_periodo_atual;

            /** Dados para fazer a inscrição */
            $data = [];
            $data['registro'] = $registro;
            $data['aluno_id'] = $aluno->id;
            $data['muralestagio_id'] = $muralestagio_id;
            $data['data'] = date('Y-m-d');
            $data['periodo'] = $periodo_mural ?? $periodo_atual;
            $data['timestamp'] = date('Y-m-d H:i:s');

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Inscrição realizada!'));
                return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Não foi possível realizar a inscrição. Tente novamente.'));
        }

        /**  Alunos com o registro */
        $estudantes = $this->Muralinscricoes->Alunos->find()
            ->select([
                    'id',
                    'registro_nome' => $this->Muralinscricoes->Alunos->find()->func()->concat([
                        'Alunos.registro' => 'identifier',
                        ' - ',
                        'Alunos.nome' => 'identifier'
                    ])
                ])
            ->order(['Alunos.nome' => 'ASC'])
            ->all();
        foreach ($estudantes as $a) {
            $alunos[$a->id] = $a->registro_nome;
        }

        /**  Muralestagios com período e instituição */
        /**  Muralestagios com o periodo */
        $mural = $this->Muralinscricoes->Muralestagios->find()
            ->select([
                    'Muralestagios.id',
                    'instituicao_periodo' => $this->Muralinscricoes->Muralestagios->find()->func()->concat([
                        'Muralestagios.periodo' => 'identifier',
                        ' - ',
                        'Muralestagios.instituicao' => 'identifier'
                    ])
                ])
            ->order(['Muralestagios.periodo' => 'DESC', 'Muralestagios.instituicao' => 'ASC'])
            ->all();
        foreach ($mural as $m) {
            $muralestagios[$m->id] = $m->instituicao_periodo;
        }
        $this->set(compact('muralinscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        try {
            $muralinscricao = $this->Muralinscricoes->get($id, [
                'contain' => ['Alunos', 'Muralestagios'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de inscrição não foi encontrado. Tente novamente.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        if ($this->request->is(['patch', 'post', 'put'])) {

            /** Ajusto o período conforme o mural de estágio selecionado */
            $mural = $this->Muralinscricoes->get($this->request->getData('id'), [
                'contain' => ['Muralestagios']
            ]);
            if (!$mural) {
                $this->Flash->error(__('Mural de estágio não localizado'));
                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
            }
            $data = $this->request->getData();
            $data['periodo'] = $mural->muralestagios->periodo;

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro de inscrição atualizado.'));
                return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Registro de inscrição não foi atualizado. Tente novamente.'));
        }

        /**  Muralestagios */
        $mural = $this->Muralinscricoes->Muralestagios->find()
            ->select([
                    'Muralestagios.id',
                    'instituicao_periodo' => $this->Muralinscricoes->Muralestagios->find()->func()->concat([
                        'Muralestagios.periodo' => 'identifier',
                        ' - ',
                        'Muralestagios.instituicao' => 'identifier'
                    ])
                ])
            ->order(['Muralestagios.periodo' => 'DESC', 'Muralestagios.instituicao' => 'ASC'])
            ->all();
        foreach ($mural as $m) {
            $muralestagios[$m->id] = $m->instituicao_periodo;
        }

        /**  Alunos */
        $estudantes = $this->Muralinscricoes->Alunos->find()
            ->select([
                    'id',
                    'registro_nome' => $this->Muralinscricoes->Alunos->find()->func()->concat([
                        'Alunos.registro' => 'identifier',
                        ' - ',
                        'Alunos.nome' => 'identifier'
                    ])
                ])
            ->order(['Alunos.nome' => 'ASC'])
            ->all();
        foreach ($estudantes as $a) {
            $alunos[$a->id] = $a->registro_nome;
        }

        $this->set(compact('muralinscricao', 'muralestagios', 'alunos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $muralinscricao = $this->Muralinscricoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de inscrição não foi encontrado. Tente novamente.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('Inscrição excluída.'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno_id]);
        } else {
            $this->Flash->error(__('Não foi possível excluir a inscrição.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $muralinscricao->id]);
        }
    }
}
