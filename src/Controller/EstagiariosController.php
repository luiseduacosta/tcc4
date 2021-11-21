<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController {

    public function initialize(): void {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL) {

        if (empty($periodo)) {
            $this->loadModel('Configuracao');
            $periodoconfiguracao = $this->Configuracao->get(1);
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        // echo "Período " . $periodo;
        if ($periodo) {
            $query = $this->Estagiarios->find('all')
                    ->where(['Estagiarios.periodo' => $periodo])
                    ->contain(['Alunos', 'Estudantes', 'Docentes', 'Supervisores', 'Instituicaoestagios', 'Areaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
                    ->contain(['Alunos', 'Estudantes', 'Docentes', 'Supervisores', 'Instituicaoestagios', 'Areaestagios']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'Estudantes.nome', 'registro', 'turno', 'nivel', 'Instituicaoestagios.instituicao', 'Supervisores.nome', 'Docentes.nome']];
        $estagiarios = $this->paginate($query, $config);
        $this->Authorization->authorize($this->Estagiarios);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set('periodo', $periodo);
        $this->set('periodos', $periodos);

        $this->set(compact('estagiarios', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        // pr($id);
        if (is_null($id)) {
            $this->Flash->error(__('Selecione um nível de estágio do estudante'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'index']);
        }
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Alunos', 'Estudantes', 'Instituicaoestagios', 'Supervisores', 'Docentes', 'Areaestagios'],
        ]);
        $this->Authorization->authorize($estagiario);
        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $estagiario = $this->Estagiarios->newEmptyEntity();
        $this->Authorization->authorize($estagiario);
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list', ['limit' => 200]);
        $estudantes = $this->Estagiarios->Estudantes->find('list', ['limit' => 200]);
        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list', ['limit' => 200]);
        $supervisores = $this->Estagiarios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Estagiarios->Docentes->find('list', ['limit' => 200]);
        $areaestagios = $this->Estagiarios->Areaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'estudantes', 'instituicaoestagios', 'supervisores', 'docentes', 'areaestagios'));
    }

    /**
     * termodecompromisso method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function termodecompromisso($id = NULL) {

        $this->Authorization->skipAuthorization();
        if ($this->getRequest()->getAttribute('identity')['categoria'] == 1):
            if (empty($id)) {
                $this->Flash->error(__('Selecionar o registro do estudante e o nível e período de estágio'));
                return $this->redirect('/estudantes/index');
                // $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
            } else {
                $estagiario_id = $id;
            }
        endif;
        if ($this->request->getData()) {
            // pr($this->request->getData());
            // die();
        }

        if (empty($periodoatual)) {
            $this->loadModel('Configuracao');
            $periodoconfiguracao = $this->Configuracao->find();
            $periodo = $periodoconfiguracao->first();
            $periodoatual = $periodo->mural_periodo_atual;
        }

        /* Se tem o id então é uma atualização */
        if ($this->request->getData('id')) {
            // die('Atualiza');
            $estagiario = $this->Estagiarios->get($this->request->getData()['id'], [
                'contain' => [],
            ]);
            $dadosinsere = $this->request->getData();
            // pr($dadosinsere);
            // die();
        } else {
            // die('Insere');
            $estagiario = $this->Estagiarios->newEmptyEntity();

            $this->loadModel('Estudantes');
            $estudante = $this->Estudantes->find()->where(['estudantes.registro' => $this->getRequest()->getSession()->read('numero')])->first();
            $estudante_id = $estudante->toArray()['id'];
            // pr($estudante_id);
            // die();
            $dadosinsere = $this->request->getData();
            $dadosinsere['alunonovo_id'] = $estudante_id;
            // pr($dadosinsere);
            // die();
        }
        // pr($dadosinsere);
        // die();
        if ($this->request->is('post')) {
            // pr($this->request->getData());
            // die();
            /* Tem que ter uma instituição */
            if (empty($dadosinsere['id_instituicao'])):
                $this->Flash->error(__('Selecione uma instituição de estágio.'));
                return $this->redirect(['action' => 'termodecompromisso']);
            endif;

            /* Atualiza o insere um novo nível e periódo de estágio */
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
            // $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                // pr($this->Estagiarios->save($estagiario));
                // die();
                $this->Flash->success(__('Estágio inserido ou atualizado.'));

                // Se foi uma atualização retorna para o id
                if ($this->request->getData('id')) {
                    // die('atualização');
                    $ultimo_id = $this->request->getData('id');
                } else {
                    // die('criação');
                    $id = $this->Estagiarios->find()->orderDesc('id')->first();
                    $ultimo_id = $id->id;
                    // pr($ultimo_id);
                    // die();
                    // Inserir dados de estudante em aluno //
                    $this->loadModel('Estudantes');
                    $queryestudantesemestagio = $this->Estudantes->find()->where(['estudantes.registro' => $this->getRequest()->getSession()->read('numero')])->first();
                    $estudantesemestagio = $queryestudantesemestagio->toArray();
                    // pr($estudantesemestagio);
                    // die();
                    $this->loadModel('Alunos');
                    $aluno = $this->Alunos->newEmptyEntity();
                    $aluno = $this->Alunos->patchEntity($aluno, $estudantesemestagio);
                    if ($this->Alunos->save($aluno, $estudantesemestagio)) {
                        $this->Flash->success(__('Aluno atualizado'));
                        /* Gravo o estagiario_id novo */
                        $this->getRequest()->getSession()->write('estagiario_id', $ultimo_id);
                    }

                    // Atualizo o estagiario novo com o id do aluno anterior
                    // pr($this->Alunos->getLastInsertID());
                    $aluno = $this->Alunos->find()->orderDesc('id')->first();
                    $aluno_id = $aluno->toArray()['id'];
                    pr($aluno_id);
                    // die('aluno_id');
                    $estagiario = $this->Estagiarios->get($ultimo_id, [
                        'contain' => []
                    ]);
                    // pr($estagiario);
                    // die('estagiario');
                    $dadosinsere['id_aluno'] = $aluno_id;
                    // pr($dadosinsere);
                    // die();
                    $estagiario = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
                    if ($this->Estagiarios->save($estagiario)):
                        $this->Flash->success(__("Estagiário atualizado"));
                    endif;
                }
                // pr($ultimo_id);
                // die();
                return $this->redirect(['action' => 'view', $ultimo_id]);
                // return $this->redirect(['action' => 'termodecompromissopdf', $ultimo_id]);
            }
            $this->Flash->error(__('Não foi possível finalizar. Tente mais uma vez.'));
        }
        // die("Inserção ou atualização");
        // Coleto dados para enviar para o formulário
        $estagios = $this->Estagiarios->find()
                ->contain(['Alunos', 'Estudantes', 'Supervisores', 'Docentes', 'Instituicaoestagios'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')])
                ->order(['Estagiarios.nivel']);

        $ultimoestagio = $estagios->last();
        // pr($ultimoestagio);
        // die();
        if ($ultimoestagio) {
            $teste = $ultimoestagio->periodo == $periodoatual;
            /* Se o periodo atual é o mesmo do periodo cadastrado deixa o nivel como está */
            if ($ultimoestagio->periodo == $periodoatual) {
                // pr("Atualização de dados do estagiario");
                // echo "Atualiza o termo de compromisso";
                $this->set('atualizar', 1);
                // Se o periodo atual é menor que o cadastrado então passa para o próximo nivel
            } elseif ($ultimoestagio->periodo < $periodoatual) {
                $ultimoestagio->periodo = $periodoatual;
                // pr($ultimoestagio->nivel);
                /* No ajuste curricular o último nível passa a ser 3 */
                ($ultimoestagio->ajustecurricular) == 0 ? $ultimonivelestagio = 4 : $ultimonivelestagio = 3;
                // pr($ultimonivelestagio);
                // die();
                if ($ultimoestagio->nivel >= $ultimonivelestagio) {
                    // Estágio não curricular
                    $ultimoestagio->nivel = 9;
                } else {
                    $ultimoestagio->nivel = $ultimoestagio->nivel + 1;
                }
                // pr($ultimoestagio->nivel);
            }
            // die($ultimoestagio);
            // $this->set('estudanteestagiario', $estudanteestagiario);
            $this->set('ultimoestagio', $ultimoestagio);
        } else {
            // Se não é estagiário então capturo a informação do estudante
            $this->loadModel('Estudantes');
            $estudante = $this->Estudantes->find()
                    ->contain('')
                    ->where(['registro' => $this->getRequest()->getSession()->read('numero')])
                    ->select(['id', 'registro', 'nome']);
            $estudante_semestagio = $estudante->first();
            $this->set('estudante_semestagio', $estudante_semestagio);
        }

        $this->set('periodo', $periodoatual);

        // $this->loadModel('Instituicaoestagios');
        /* Supervisores da instituição */
        if ($ultimoestagio):
            $supervisores_instituicao_query = $this->Estagiarios->Instituicaoestagios->find()
                    ->contain(['Supervisores'])
                    ->where(['instituicaoestagios.id' => $ultimoestagio->instituicaoestagio->id]);
            $supervisores_instituicao = $supervisores_instituicao_query->first();
            // pr($supervisores_instituicao->supervisores);
            foreach ($supervisores_instituicao->supervisores as $c_supervisor):
                // pr($c_supervisor);
                $supervisoresdainstituicao[$c_supervisor->id] = $c_supervisor->nome;
            endforeach;
        // pr($supervisoresdainstituicao);
        // die();
        endif;

        $alunos = $this->Estagiarios->Alunos->find('list', ['limit' => 200]);
        $estudantes = $this->Estagiarios->Estudantes->find('list', ['limit' => 200]);
        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $docentes = $this->Estagiarios->Docentes->find('list', ['limit' => 200]);
        $areaestagios = $this->Estagiarios->Areaestagios->find('list', ['limit' => 200]);
        $this->set(compact('alunos', 'estudantes', 'instituicaoestagios', 'supervisores', 'docentes', 'areaestagios'));
        if (isset($supervisoresdainstituicao)):
            $this->set('supervisoresdainstituicao', $supervisoresdainstituicao);
        endif;
    }

    public function termodecompromissopdf($id = NULL) {

        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o registro do estudante e o nível e período de estágio'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Alunos', 'Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.id' => $id]);
        }
        // pr($estagiario->first());
        // die();
        $this->loadModel('Configuracao');
        $configuracao = $this->Configuracao->get(1);
        // pr($configuracao);
        // die();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'termo_de_compromisso_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );
        $this->set('configuracao', $configuracao);
        $this->set('estagiario', $estagiario->first());
    }

    public function selecionadeclaracaodeestagio($id = NULL) {

        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function declaracaodeestagiopdf($id = NULL) {

        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.id' => $id]);
        }

        $estagiorealizado = $estagiarioquery->first();
        // pr($estagiorealizado);
        // die('estagiorealizado');

        if (empty($estagiorealizado->estudante->identidade)) {
            $this->Flash->error(__("Estudante sem RG"));
            return $this->redirect('/estudantes/view/' . $estagiorealizado->estudante->id);
        }

        if (empty($estagiorealizado->estudante->orgao)) {
            $this->Flash->error(__("Estudante não especifica o orgão emisor do documento"));
            return $this->redirect('/estudantes/view/' . $estagiorealizado->estudante->id);
        }
        if (empty($estagiorealizado->estudante->cpf)) {
            $this->Flash->error(__("Estudante sem CPF"));
            return $this->redirect('/estudantes/view/' . $estagiorealizado->estudante->id);
        }

        if (empty($estagiorealizado->supervisor->id)) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            return $this->redirect('/estagiarios/view/' . $estagiorealizado->id);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'declaracao_de_estagio_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );
        $this->set('estagiario', $estagiorealizado);
    }

    public function selecionafolhadeatividades($id = NULL) {

        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante e o estágio'));
            return $this->redirect('/estudantes/index');
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function folhadeatividadespdf($id = NULL) {

        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Por favor selecionar o estágio do estudante'));
            if ($this->getRequest()->getSession()->read('numero')):
                return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('numero'));
            else:
                return $this->redirect('/estudantes/index');
            endif;
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Docentes'])
                    ->where(['Estagiarios.id' => $id]);
        }

        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die('estagioario');

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
        $this->set('estagiario', $estagiario);
    }

    public function selecionaavaliacaodiscente($id = NULL) {

        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function avaliacaodiscentepdf($id) {

        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Docentes'])
                    ->where(['Estagiarios.id' => $id]);
        }

        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die('estagioario');

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
        $this->set('estagiario', $estagiario);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
            $this->cakeError('error404');
        } else {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => [],
            ]);
            $this->Authorization->authorize($estagiario);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());

            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Estagiario atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list');
        $estudantes = $this->Estagiarios->Estudantes->find('list');
        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $docentes = $this->Estagiarios->Docentes->find('list', ['limit' => 500]);
        $areaestagios = $this->Estagiarios->Areaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'estudantes', 'instituicaoestagios', 'supervisores', 'docentes', 'areaestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        $this->Authorization->authorize($estagiario);
        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Estagiário excluído.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o estagiário'));
        }

        return $this->redirect(['controller' => 'estudantes', 'action' => 'view?registro=' . $estagiario->registro]);
    }

    public function lancanota($id = null) {

        $this->Authorization->skipAuthorization();
        $siape = $this->getRequest()->getQuery('siape');
        if (!isset($siape) && empty($siape)):
            $this->Flash->error(__('Somente docentes podem realizar esta operação'));
            return $this->redirect('/userestagios/logout');
        endif;

        $idquery = $this->Estagiarios->Docentes->find()
                ->contain([
                    'Estagiarios' => ['sort' => ['periodo' => 'desc'],
                        'Estudantes' => ['fields' => ['id', 'nome'], 'sort' => ['nome']],
                        'Docentes' => ['fields' => ['id', 'nome', 'siape']],
                        'Supervisores' => ['fields' => ['id', 'nome']],
                        'Instituicaoestagios' => ['fields' => ['id', 'instituicao']],
                        'Avaliacoes' => ['fields' => ['id', 'estagiario_id']]
                    ]
                ])
                ->where(['siape' => $siape]);

        // $estagiariosfolha = $idquery->distinct(['estagiario_id']);
        $estagiarios = $idquery->first();
        // pr($estagiarios);
        $i = 0;
        $estagiarioslancanota[] = null;
        foreach ($idquery as $estagiario):
            // pr($estagiario);
            // $estagiarioslancanota[$i]['periodo'] = $estagiario;
            foreach ($estagiario->estagiarios as $c_estagio):
                // pr($c_estagio);
                $estagiarioslancanota[$i]['id'] = $c_estagio['id'];
                $estagiarioslancanota[$i]['registro'] = $c_estagio['registro'];
                $estagiarioslancanota[$i]['periodo'] = $c_estagio['periodo'];
                $estagiarioslancanota[$i]['nivel'] = $c_estagio['nivel'];
                $estagiarioslancanota[$i]['nota'] = $c_estagio['nota'];
                $estagiarioslancanota[$i]['ch'] = $c_estagio['ch'];
                // pr($c_estagio->instituicaoestagio);
                // pr($c_estagio->supervisor);
                // pr($c_estagio->docente);
                // pr($c_estagio->estudante);
                $this->loadModel('Folhadeatividades');
                $folhaquery = $this->Folhadeatividades->find()
                        ->where(['Folhadeatividades.estagiario_id' => $c_estagio->id]);
                $folha = $folhaquery->first();
                if ($folha):
                // pr($folha);
                endif;
                $estagiarioslancanota[$i]['instituicao_id'] = $c_estagio->instituicaoestagio->id;
                $estagiarioslancanota[$i]['instituicao'] = $c_estagio->instituicaoestagio->instituicao;
                $estagiarioslancanota[$i]['supervisor_id'] = $c_estagio->supervisor->id;
                $estagiarioslancanota[$i]['supervisora'] = $c_estagio->supervisor->nome;
                $estagiarioslancanota[$i]['docente_id'] = $c_estagio->docente->id;
                $estagiarioslancanota[$i]['docente'] = $c_estagio->docente->nome;
                $estagiarioslancanota[$i]['estudante_id'] = $c_estagio->estudante->id;
                $estagiarioslancanota[$i]['estudante'] = $c_estagio->estudante->nome;
                if (isset($folha)):
                    $estagiarioslancanota[$i]['folha_id'] = $folha->id;
                else:
                    $estagiarioslancanota[$i]['folha_id'] = null;
                endif;
                if (isset($c_estagio->avaliacao->id)):
                    $estagiarioslancanota[$i]['avaliacao_id'] = $c_estagio->avaliacao->id;
                else:
                    $estagiarioslancanota[$i]['avaliacao_id'] = null;
                endif;
                $i++;
            endforeach;

        endforeach;
        // pr($estagiarioslancanota);
        // die();
        $this->set('estagiarios', $estagiarioslancanota);
    }

}
