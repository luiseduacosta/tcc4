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
                'sortableFields' => ['id', 'id_aluno', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp'],
                'conditions' => ['muralinscricoes.periodo' => $periodo],
                'order' => ['Estudantes.nome']
            ];
        } else {
            $this->paginate = [
                'contain' => ['Alunos', 'Muralestagios'],
                'sortableFields' => ['id', 'id_aluno', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp'],
                'order' => ['Estudantes.nome']
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

        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();
        $this->Authorization->authorize($muralinscricao);

        if ($this->request->is('post')) {
            // die('is post');
            if ($this->request->getSession()->read('id_categoria') == 2):
                $dre = $this->request->getSession()->read('numero');
                // pr($dre);
                /* Verifica se já fez inscricações para essa mesma vaga de estágio */
                $verifica = $this->Muralinscricoes->find()
                    ->contain([])
                    ->where(['id_instituicao' => $id, 'id_aluno' => $dre])
                    ->select(['id']);
                $verifica_id = $verifica->first();
                // pr($verifica_id);
                if ($verifica_id) {
                    $this->Flash->error(__('Inscrição já realizada'));
                    return $this->redirect('/muralinscricoes/view/' . $verifica_id->id);
                }
                // die();
                $data = $this->request->getData();

                $alunotable = $this->fetchTable('Alunos');
                $aluno = $alunotable->find()->where(['registro' => $dre])->select(['id']);
                $aluno_id = $aluno->first();
                // pr($aluno_id);

                $configuracaotable = $this->fetchTable('Configuracao');
                $periodo = $configuracaotable->get(1);
                $periodo = $periodo->mural_periodo_atual;

                $data['id_aluno'] = $dre;
                $data['aluno_id'] = $aluno_id['id'];
                $data['data'] = date('Y-m-d');
                $data['periodo'] = $periodo;
                // pr($data);
                // die();
            else:
                $this->Flash->error(__('Precisa do DRE do estudante para fazer inscrição'));
                return $this->redirect('/muralinscricoes/index');
            endif;

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
            // pr($muralinscricao);
            // die();
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Inscrição realizada!'));
                $ultimo_id = $this->Muralinscricoes->find()->orderDesc('id')->first();
                return $this->redirect(['action' => 'view', $ultimo_id->id]);
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
        $muralestagios_id = $this->getRequest()->getQuery('id_instituicao');
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

        $estudantes = $this->Muralinscricoes->Estudantes->find('list');
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list');
        $this->set(compact('muralinscricao', 'estudantes', 'muralestagios', 'periodos', 'alunonovos', 'alunoestagios'));
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
            'contain' => ['Estudantes'],
        ]);
        $this->Authorization->authorize($muralinscricao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro muralinscricao atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
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
        $estudantes = $this->Muralinscricoes->Estudantes->find('list');
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
