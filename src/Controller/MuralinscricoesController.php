<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralinscricoes Controller
 *
 * @property \App\Model\Table\MuralinscricoesTable $Muralinscricoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
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
            $this->paginate = [
                'contain' => ['Alunos', 'Muralestagios'],
                'sortableFields' => ['id', 'registro', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp'],
                'conditions' => ['muralinscricoes.periodo' => $periodo],
                'order' => ['Alunos.nome']
            ];
        } else {
            $this->paginate = [
                'contain' => ['Alunos', 'Muralestagios'],
                'sortableFields' => ['id', 'registro', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp'],
                'order' => ['Alunos.nome']
            ];
        }

        $muralinscricoes = $this->paginate($this->Muralinscricoes);
        $this->Authorization->authorize($this->Muralinscricoes);

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

        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => ['Alunos', 'Muralestagios']
        ]);
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
            return $this->redirect('/muralestagios/index');
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
                    return $this->redirect('/alunos/index');
                }
                /* Verifica se já fez inscricações para essa mesma vaga de estágio */
                $verifica = $this->Muralinscricoes->find()
                    ->contain([])
                    ->where(['muralestagio_id' => $muralestagio_id, 'registro' => $dre])
                    ->select(['id'])
                    ->first();
                // pr($verifica_id);
                if ($verifica) {
                    $this->Flash->error(__('Inscrição já realizada'));
                    return $this->redirect('/muralinscricoes/view/' . $verifica->id);
                }
                // die();
                $data = $this->request->getData();

                $alunotable = $this->fetchTable('Alunos');
                $aluno = $alunotable->find()
                    ->where(['registro' => $dre])
                    ->select(['id'])
                    ->first();
                // pr($aluno);

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
                return $this->redirect('/alunos/index');
            }

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
            // pr($muralinscricao);
            // die();
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Inscrição realizada!'));
                return $this->redirect(['action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Não foi possível realizar a inscrição. Tente outra vez.'));
        }

        /* Periodos */
        $periodototal = $this->Muralinscricoes->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        /* Muralestagios */
        $muralestagios_id = $this->getRequest()->getQuery('muralestagio_id');
        if ($muralestagios_id):
            $instituicao = $this->Muralinscricoes->Muralestagios->find()
                ->where(['muralestagios.id' => $muralestagios_id])
                ->select(['muralestagios.id', 'muralestagios.instituicao', 'muralestagios.periodo']);

            $this->set('muralestagios_id', $instituicao->first());
        else:
            $this->Flash->error(__('Selecionar uma instituição para a qual quer fazer inscrição.'));
            $this->redirect('/muralestagios/index');
        endif;

        $alunotable = $this->fetchTable('Alunos');
        $alunoestagios = $alunotable->find()
            ->where(['alunos.registro' => $this->getRequest()->getSession()->read('numero')])
            ->select(['alunos.id', 'alunos.nome']);
        $alunoestagios = $alunoestagios->first();

        // pr($alunonovos);
        // pr($alunoestagio);
        // die();

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

        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => ['Alunos'],
        ]);
        $this->Authorization->authorize($muralinscricao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro muralinscricao atualizado.'));

                return $this->redirect(['action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Registro muralinscricao não foi atualizado. Tente novamente.'));
        }

        $periodototal = $this->Muralinscricoes->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        // pr($periodos);
        // die();
        $estudantes = $this->Muralinscricoes->Alunos->find('list');
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list');
        $this->set(compact('muralinscricao', 'estudantes', 'muralestagios', 'periodos'));
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

        $registro = $this->Muralinscricoes->find()->where(['id' => $id])->select(['alunonovo_id']);
        // pr($registro);
        $registro_id = $registro->first();
        // pr($registro_id->alunonovo_id);
        // die();
        $this->request->allowMethod(['post', 'delete']);
        $muralinscricao = $this->Muralinscricoes->get($id);
        $this->Authorization->authorize($muralinscricao);

        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('Inscrição excluída.'));
        } else {
            $this->Flash->error(__('Não foi realizar a exclução.'));
        }

        return $this->redirect(['controller' => 'estudantes', 'action' => 'view/' . $registro_id->alunonovo_id]);
    }

}
