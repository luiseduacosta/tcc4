<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Avaliacoes Controller
 *
 * @property \App\Model\Table\AvaliacoesTable $Avaliacoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Avaliacoes
 * @method \App\Model\Entity\Avaliaco[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AvaliacoesController extends AppController
{

    /**
     * Index method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function index($id = NULL)
    {
        /** O id enviado pelo submenu_navegacao corresponde ao estagiario_id */
        $this->Authorization->skipAuthorization();
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar estagiário, período e nível de estágio a ser avaliado'));
            $user = $this->getRequest()->getAttribute('identity');
            if ($user->categoria == '2'):
                return $this->redirect('/estudantes/view?registro=' . $user->numero);
            else:
                return $this->redirect('/estudantes/index');
            endif;
        } else {
            /** Captura o registro do estagiário a partir do estagiario_id */
            $registro = $this->Avaliacoes->Estagiarios->find()
                ->where(['Estagiarios.id' => $id])
                ->first();
            /**  Captura os estágios do aluno */
            $estagios = $this->Avaliacoes->Estagiarios->find()
                ->contain(['Estudantes', 'Instituicoes', 'Supervisores', 'Avaliacoes'])
                ->where(['Estagiarios.aluno_id' => $registro->aluno_id]);
            $this->set('id', $id);
            $this->set('estagios', $estagios);
        }
    }

    /**
     * Supervisoravaliacao method
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function supervisoravaliacao($id = NULL)
    {

        /* O submenu_navegacao envia o cress */
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if ($user->categoria == '4') {
            $cress = $user->numero;
        } elseif ($user->categoria == '2') {
            $dre = $user->numero;
        }
        if (empty($cress)) {
            $this->Flash->error(__('Selecionar estagiário, período e nível de estágio a ser avaliado'));
            if ($dre):
                return $this->redirect('/estudantes/view?registro=' . $dre);
            else:
                return $this->redirect('/estudantes/index');
            endif;
        } else {
            $estagiario = $this->Avaliacoes->Estagiarios->find()
                ->contain(['Supervisores', 'Estudantes', 'Professores', 'Folhadeatividades'])
                ->where(['Supervisores.cress' => $cress])
                ->order(['periodo' => 'desc'])
                ->first();
            $this->set('estagiario', $estagiario);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $avaliacao = $this->Avaliacoes->get($id, [
            'contain' => ['Estagiarios' => ['Estudantes', 'Professores', 'Instituicaoestagios', 'Supervisores']],
        ]);
        $this->Authorization->authorize($avaliacao);

        $this->set(compact('avaliacao'));
    }

    /**
     * Add method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id == NULL) {
            $this->Flash->error(__('Selecione um nível e período de estágio do estudante'));
            $user = $this->getRequest()->getAttribute('identity');
            if ($user->categoria == '2'):
                return $this->redirect(['controller' => 'alunos', 'action' => 'view', $user->numero]);
            else:
                return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
            endif;
        } else {
            $avaliacaoverifica = $this->Avaliacoes->find()
                ->where(['estagiario_id' => $estagiario_id])
                ->first();
            if (isset($avaliacaoverifica) && !is_null($avaliacaoverifica)) {
                $this->Flash->error(__('Estagiário já foi avaliado'));
                return $this->redirect(['controller' => 'avaliacoes', 'action' => 'view', $avaliacaoverifica->id]);
            }
        }

        $avaliacao = $this->Avaliacoes->newEmptyEntity();
        $this->Authorization->authorize($avaliacao);
        if ($this->request->is('post')) {
            $avaliacao = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__('Avaliação registrada.'));
                return $this->redirect(['controller' => 'avaliacoes', 'action' => 'index', $estagiario_id]);
            }
            $this->Flash->error(__('Avaliação não foi registrada. Tente novamente.'));
        }
        $estagiario = $this->Avaliacoes->Estagiarios->find()
            ->contain(['Alunos'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $avaliacao = $this->Avaliacoes->get($id, [
            'contain' => ['Estagiarios' => 'Estudantes'],
        ]);
        $this->Authorization->authorize($avaliacao);
        $estagiario = $avaliacao->estagiarios;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $avaliacao = $this->Avaliacoes->patchEntity($avaliacao, $this->request->getData());
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__('Avaliação atualizada.'));
                return $this->redirect(['action' => 'index', $avaliacao->estagiario_id]);
            }
            $this->Flash->error(__('Avaliação não atualizada. Tente novamente.'));
        }
        $this->set(compact('avaliacao', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $avaliacao = $this->Avaliacoes->get($id);
        $this->Authorization->authorize($avaliacao);
        if ($this->Avaliacoes->delete($avaliacao)) {
            $this->Flash->success(__('Avaliação excluída.'));
        } else {
            $this->Flash->error(__('Avaliação não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Selecionaavaliacao method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function selecionaavaliacao($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if ($id == NULL) {
            if ($user->categoria == '2') {
                $dre = $user->numero;
                $estagiario = $this->Avaliacoes->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $dre])
                    ->first();
                
                if ($estagiario) {
                    $id = $estagiario->id;
                } else {
                    $this->Flash->error(__('Selecionar o estudante estagiário'));
                    return $this->redirect('/estudantes/index');
                }                
            } else {
                $this->Flash->error(__('Selecionar o estudante estagiário'));
                return $this->redirect('/estudantes/index');
            }
        } else {
            $estagiario = $this->Avaliacoes->Estagiarios->find()
                ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                ->where(['Estagiarios.id' => $id])
                ->first();
        }
        $this->set('estagiario', $estagiario);
    }

    /**
     * Imprimeavaliacaopdf method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimeavaliacaopdf($id = NULL)
    {

        /* No login foi capturado o id do estagiário */
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('');
        if (is_null($id)) {
            $this->Flash->error(__('Por favor selecionar a folha de avaliação do estágio do estudante'));
            return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('numero'));
        } else {
            $avaliacaoquery = $this->Avaliacoes->find()
                ->contain(['Estagiarios' => ['Estudantes', 'Supervisores', 'Professores', 'Instituicaoestagios']])
                ->where(['Avaliacoes.id' => $id]);
        }
        $avaliacao = $avaliacaoquery->first();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'avaliacao_discente_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('avaliacao', $avaliacao);
    }

}
