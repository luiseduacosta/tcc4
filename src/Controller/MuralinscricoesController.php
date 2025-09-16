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
        $this->Authorization->authorize($this->Muralinscricoes);
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
                'contain' => ['Alunos', 'Muralestagios']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de inscricoes para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        $this->set(compact('muralinscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $muralestagio_id = $this->request->getData('muralestagio_id');
        if ($muralestagio_id) {
            $this->set('muralestagio_id', $muralestagio_id);
        } else {
            $this->Flash->error(__('Selecionar um mural de estágio para a qual quer fazer inscrição.'));
            return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
        }

        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();
        $this->Authorization->authorize($muralinscricao);

        if ($this->request->is('post')) {
            $user = $this->request->getAttribute('identity');
            if (isset($user) && ($user->get('categoria') == '1' || $user->get('categoria') == '2')) {
                $dre = $user->get('numero');
                if (empty($dre)) {
                    $dre = $this->request->getData('registro');
                }
                if (empty($dre)) {
                    $this->Flash->error(__('Precisa do DRE do estudante para fazer inscrição'));
                    return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
                }
                /** Verifica se já fez inscricações para essa mesma vaga de estágio */
                $verifica = $this->Muralinscricoes->find()
                    ->contain([])
                    ->where(['muralestagio_id' => $muralestagio_id, 'registro' => $dre])
                    ->select(['id'])
                    ->first();
                // pr($verifica_id);
                if ($verifica) {
                    $this->Flash->error(__('Inscrição já realizada'));
                    return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $verifica->id]);
                }
                $data = $this->request->getData();

                $alunotable = $this->fetchTable('Alunos');
                $aluno = $alunotable->find()
                    ->where(['registro' => $dre])
                    ->select(['id'])
                    ->first();

                $configuracaotable = $this->fetchTable('Configuracao');
                $periodo = $configuracaotable->get(1);
                $periodo = $periodo->mural_periodo_atual;

                $data['registro'] = $dre;
                $data['aluno_id'] = $aluno['id'];
                $data['data'] = date('Y-m-d');
                $data['periodo'] = $periodo;
                // pr($data);
                // die();
            } else {
                $this->Flash->error(__('Precisa do DRE do estudante para fazer inscrição'));
                return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
            }

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
            // pr($muralinscricao);
            // die();
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Inscrição realizada!'));
                return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Não foi possível realizar a inscrição. Tente outra vez.'));
        }

        /** Periodos */
        $periodototal = $this->Muralinscricoes->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        /**  Muralestagios */
        $muralestagios_id = $this->getRequest()->getQuery('muralestagio_id');
        if ($muralestagios_id):
            $instituicao = $this->Muralinscricoes->Muralestagios->find()
                ->where(['muralestagios.id' => $muralestagios_id])
                ->select(['muralestagios.id', 'muralestagios.instituicao', 'muralestagios.periodo']);

            $this->set('muralestagios_id', $instituicao->first());
        else:
            $this->Flash->error(__('Selecionar uma instituição para a qual quer fazer inscrição.'));
            return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
        endif;

        $alunotable = $this->fetchTable('Alunos');
        $alunoestagios = $alunotable->find()
            ->where(['alunos.registro' => $this->getRequest()->getSession()->read('numero')])
            ->select(['alunos.id', 'alunos.nome']);
        $alunoestagios = $alunoestagios->first();

        $estudantes = $this->Muralinscricoes->Alunos->find('list');
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list');
        $this->set(compact('muralinscricao', 'estudantes', 'muralestagios', 'periodos', 'alunoestagios'));
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
            $this->Flash->error(__('Registro muralinscricao não foi encontrado. Tente novamente.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro muralinscricao atualizado.'));
                return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Registro muralinscricao não foi atualizado. Tente novamente.'));
        }

        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list', ['order' => ['instituicao' => 'ASC']]);
        $alunos = $this->Muralinscricoes->Alunos->find('list', ['order' => ['nome' => 'ASC']]);
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
            $this->Flash->error(__('Registro muralinscricao não foi encontrado. Tente novamente.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'index']);
        }
        $this->Authorization->authorize($muralinscricao);
        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('Inscrição excluída.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir a inscrição.'));
            return $this->redirect(['controller' => 'muralinscricoes', 'action' => 'index']);
        }
    }
}
