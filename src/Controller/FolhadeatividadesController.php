<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Folhadeatividades Controller
 *
 * @property \App\Model\Table\FolhadeatividadesTable $Folhadeatividades
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolhadeatividadesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL) {

        $this->Authorization->skipAuthorization();
        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        }

        $estagiarioquery = $this->Folhadeatividades->Estagiarios->find()
                ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Professores'])
                ->where(['Estagiarios.Id' => $id])
                ->select(['Estagiarios.nivel', 'Estagiarios.periodo', 'Estudantes.nome', 'Supervisores.nome', 'Instituicaoestagios.instituicao', 'Professores.nome']);
        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die();

        $this->paginate = [
            'conditions' => ['Folhadeatividades.estagiario_id' => $id],
            'order' => ['dia'],
        ];
        $folhadeatividades = $this->paginate($this->Folhadeatividades);
        $this->Authorization->authorize($this->Folhadeatividades);

        $this->set(compact('folhadeatividades', 'id', 'estagiario'));
    }

    /**
     * View method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $folhadeatividade = $this->Folhadeatividades->get($id, [
            'contain' => ['Estagiarios'],
        ]);
        $this->Authorization->authorize($folhadeatividade);
        $this->set(compact('folhadeatividade'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL) {

        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estágio'));
            return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('numero'));
        } else {
            $estagiariotable = $this->fetchTable('Estagiarios');
            $estagiarioquery = $estagiariotable->find()
                    ->contain(['Estudantes'])
                    ->where(['Estagiarios.id' => $id]);

            if (!$estagiarioquery) {
                $this->Flash->error(__('Estudante sem estágio cadastrado'));
                return $this->redirect('/Estudantes/view/' . $id);
            }
        }

        $folhadeatividade = $this->Folhadeatividades->newEmptyEntity();
        $this->Authorization->authorize($folhadeatividade);

        if ($this->request->is('post')) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            // pr($this->request->getData());
            // die();
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividades cadastrada!'));

                return $this->redirect(['action' => 'index', $id]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        }
        /*
          $estagiariocategoria = $this->getRequest()->getSession()->read('id_categoria');
          $estagiarionumero = $this->getRequest()->getSession()->read('numero');
          if ($estagiariocategoria == 2) {
          $estagiariotable = $this->fetchtable('Estagiarios');
          $estudantequery = $estagiariotable->find()
          ->contain(['Estudantes'])
          ->where(['estagiarios.registro' => $estagiarionumero]);

          }
          // $estagiario = $this->Folhadeatividades->Estagiarios->find('list', ['limit' => 200]);
         * */
        $estagiario = $estagiarioquery->first();
        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $folhadeatividade = $this->Folhadeatividades->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($folhadeatividade);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividade atualizada.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar. Tente outra vez.'));
        }
        $estagiarioquery = $this->Folhadeatividades->find()
                ->where(['Folhadeatividades.id' => $id])
                ->contain(['Estagiarios' => ['Estudantes']])
                ->select(['Estagiarios.id', 'Estudantes.nome']);
        // pr($estagiarioquery->first());
        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die();
        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $folhadeatividade = $this->Folhadeatividades->get($id);
        $this->Authorization->authorize($folhadeatividade);

        if ($this->Folhadeatividades->delete($folhadeatividade)) {
            $this->Flash->success(__('The folhadeatividade has been deleted.'));
        } else {
            $this->Flash->error(__('The folhadeatividade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function selecionafolhadeatividades($id = NULL) {

        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        } else {
            $estagiariotable = $this->fetchTable('Estagiarios');
            $estagiarioquery = $estagiariotable->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')]);
            $estagiario = $estagiarioquery->all();
            $this->set('estagiario', $estagiario);
        }
        // pr($estagiarios);
        // die();
    }

    public function folhadeatividadespdf($id = NULL) {

        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        } else {
            $folhaquery = $this->Folhadeatividades->find()
                    ->where(['Folhadeatividades.estagiario_id' => $id]);

            $estagiarioquery = $this->Folhadeatividades->find()
                    ->contain(['Estagiarios' => ['Estudantes', 'Professores', 'Instituicaoestagios', 'Supervisores']])
                    ->where(['Estagiarios.id' => $id]);
        }

        $atividades = $folhaquery->all();
        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'folha_de_atividades_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );
        $this->set('atividades', $atividades);
        $this->set('estagiario', $estagiario);
    }

}
