<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Rule\IsUnique;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        $periodo = $this->getRequest()->getQuery('periodo');
        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }
        $this->Authorization->skipAuthorization();
        if ($periodo) {
            $query = $this->Estagiarios->find('all')
                ->where(['Estagiarios.periodo' => $periodo])
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome']];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => ['periodo' => 'asc']
        ]);
        $periodos = $periodototal->toArray();
        $ultimoperiodo = end($periodos);
        if ($ultimoperiodo > $periodo) {
            $this->Flash->error(__('Período atual selecionado ' . $periodo . ' é anterior ao último periódo cursado ' . $ultimoperiodo));
        }

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
    public function view($id = null)
    {
        /** Corrigir */
        $this->Authorization->skipAuthorization();
        // pr($id);
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Alunos', 'Instituicoes', 'Supervisores', 'Professores', 'Turmaestagios']
        ]);

        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     * @param string|null $aluno_id ID do aluno
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL)
    {

        /** Corrigir */
        $this->Authorization->skipAuthorization();

        $estagiario = $this->Estagiarios->newEmptyEntity();
        // pr($this->request->getData());
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            // pr($estagiario);
            // die();
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Registro de estagiario inserido.'));

                return $this->redirect(['action' => 'view', $estagiario->id]);
            }
            $this->Flash->error(__('Registro de estagiario nao foi inserido. Tente novamente.'));
        }

        $this->Authorization->skipAuthorization();
        $aluno_id = $this->getRequest()->getQuery('aluno_id');
        if ($aluno_id) {
            $estagiario = $this->Estagiarios->find()
                ->where(['aluno_id' => $aluno_id])
                ->order(['nivel' => 'desc'])
                ->first();
            if ($estagiario) {
                $this->Flash->success(__('O aluno é estagiário ' . $estagiario->nivel . ' no periodo ' . $estagiario->periodo));
                $nivel = $estagiario->nivel + 1;
                $ajuste2020 = $estagiario->ajuste2020;
                if ($ajuste2020 == 1) { // Ajuste 2020 sim
                    if ($nivel > 3) {
                        $nivel = 9;
                    }
                } elseif ($ajuste2020 == 0) { // Ajuste 2020 não
                    if ($nivel > 4) {
                        $nivel = 9;
                    }
                }
                $this->set('nivel', $nivel);
            } else {
                $this->Flash->success(__('O aluno não é estagiário'));
                $this->set('nivel', 1);
            }
            $aluno = $this->fetchTable('Alunos')->find()->where(['id' => $aluno_id])->first();
            $this->set('aluno', $aluno);
        } else {
            $alunos = $this->fetchTable('Alunos')->find('list');
            $this->set('alunos', $alunos);
        }
        $periodo = $this->fetchTable('Configuracoes')->find()->select(['mural_periodo_atual'])->first();
        $this->set('periodo', $periodo);
        $instituicoes = $this->fetchTable('Instituicoes')->find('list');
        $supervisores = $this->fetchTable('Supervisores')->find('list');
        $professores = $this->fetchTable('Professores')->find('list');
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list');
        $this->set(compact('estagiario', 'instituicoes', 'supervisores', 'professores', 'turmaestagios'));
    }

    /**
     * termodecompromisso method
     * 
     * @param scalar $id_aluno
     * @param string $periodo
     * @param scalar $nivel
     * @param string $ajuste2020
     * 
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * Pode receber como parâmetro o id do estagiário ou o id do estudante.
     */
    public function termodecompromisso($id = NULL)
    {

        // pr($this->request->getAttribute('params'));
        $aluno_id = $this->getRequest()->getQuery('aluno_id');
        $instituicao_id = $this->getRequest()->getQuery('instituicao_id');

        if ($instituicao_id) {
            // pr($instituicao_id);
        }
        // die();

        /** O administrador pode fazer Termo de Compromisso. Precisa do DRE ou ID do estudante */
        if ($this->getRequest()->getSession()->read('categoria') == 1) {
            if ($id) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['Estagiarios.id' => $id])
                    ->first();

                // die();
                $registro = $estagiario->registro;
                $estudante_id = $estagiario->estudante_id;
                // die();
                $estudante = $this->Estagiarios->Alunos->find()
                    ->contain(['Estagiarios'])
                    ->where(['Estudantes.registro' => $registro])
                    ->first();
            } else {
                $estudante_id = $this->getRequest()->getQuery('estudante_id');
                $estudante = $this->Estagiarios->Alunos->find()
                    ->contain(['Estagiarios'])
                    ->where(['Estudantes.id' => $estudante_id])
                    ->first();

                $registro = $estudante->registro;
            }
        }

        // die();

        /** Apenas para efeitos de depuração do código.
         * Captura os dados enviados pelo formulário.
         */
        if ($this->getRequest()->getData()) {
            // pr($this->getRequest()->getData());
            // die();
        }

        $estudantestabela = $this->fetchTable('Alunos');

        if ($this->getRequest()->is('post')) {
            // pr($this->getRequest()->getData());
            // die();

            /**
             * Prepara a variavel $dadosinsere para inserir os dados do formulário.
             * Discrimina se é uma atualização ou uma inserção.
             * Se tem o id então é uma atualização
             */
            if ($this->getRequest()->getData('id')) {
                // die('Atualiza');
                $estagiario = $this->Estagiarios->get($this->getRequest()->getData('id'), [
                    'contain' => [],
                ]);
                $dadosinsere = $this->getRequest()->getData();
                // pr($dadosinsere);
                // die();
            } else {
                // die('Insere registro novo');
                $estagiario = $this->Estagiarios->newEmptyEntity();

                /** Capturo o id do estudante para passar para o estagiario */
                $estudante = $estudantestabela->find()
                    ->contain([])
                    ->where(['aluno.id' => $aluno_id])
                    ->first();
                // pr($estudante);
                // die();
                $dadosinsere = $this->getRequest()->getData();
                $dadosinsere['aluno_id'] = $estudante->id;
                // pr($dadosinsere);
                // die();
            }

            // pr($dadosinsere);
            // die();

            /** Tem que ter uma instituição */
            if (empty($dadosinsere['instituicao_id'])) {
                if ($this->getRequest()->getQuery('instituicao_id')) {
                    $dadosinsere['instituicao_id'] = $this->getRequest()->getQuery('instituicao_id');
                } else {
                    $this->Flash->error(__('Selecione uma instituição de estágio.'));
                    return $this->redirect(['action' => 'termodecompromisso']);
                }
            }

            // pr($dadosinsere);
            // pr($estagiario);
            // die();

            /** Atualiza ou insere o registro em Estagiarios. */
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
            // $estagiario->clean(); // Para eliminar o dirty dos entity nos campos que mudam de valor
            if ($this->Estagiarios->save($estagiario)) {

                $this->Flash->success(__('Estágio criado ou atualizado.'));
                /** Gravo o cookie estagiario_id para que o menu superior fique com o submenu_aluno */
                $this->getRequest()->getSession()->write('estagiario_id', $estagiario->id);

                // Se foi uma atualização retorna para o id
                if ($this->getRequest()->getData('id')) {
                    // die('atualização');
                    $ultimo_id = $this->getRequest()->getData('id');
                } else {
                    // die('criação');
                    $id = $this->Estagiarios->find()->orderDesc('id')->first();
                    $ultimo_id = $id->id;
                    // pr($ultimo_id);
                    // die();

                    /**
                     * Inserir dados de estudante em alunoestagiario.
                     * Antes, precisa verificar se o aluno já está cadastrado.
                     */
                    $alunostabela = $this->fetchTable('Alunoestagiarios');
                    $aluno = $alunostabela->find()->where(['registro' => $dadosinsere['registro']])->first();
                    // pr($aluno);
                    // die();
                    if ($aluno) {
                        // echo "Aluno já está cadastrado" . "<br>";
                    } else {
                        $queryestudantesemestagio = $estudantestabela->find()
                            ->where(['Estudantes.id' => $estudante_id])
                            ->first();
                        $estudantesemestagio = $queryestudantesemestagio->toArray();
                        // pr($estudantesemestagio);
                        // die();
                        $aluno_novo = $alunostabela->newEmptyEntity();
                        // pr($aluno_novo);
                        // pr($estudantesemestagio);
                        // die();
                        $aluno_novo = $alunostabela->patchEntity($aluno_novo, $estudantesemestagio);
                        if ($alunostabela->save($aluno_novo)) {
                            $this->Flash->success(__('Aluno atualizado'));
                        } else {
                            echo "Não foi possivel inserir o registro Alunos" . "<br>";
                        }
                        // debug(($aluno_novo));
                    }
                    // pr($dadosinsere);
                    // die();
                    /** Finaliza a insercao dos dados do estudante no aluno. */
                    /** Atualizo o estagiario novo com o id do aluno */
                    $aluno = $alunostabela->find()
                        ->where(['Alunos.registro' => $dadosinsere['registro']])
                        ->first();

                    $aluno_id = $aluno->toArray()['id'];
                    // pr($aluno_id);
                    // die('aluno_id');

                    $estagiario_aluno_id = $this->Estagiarios->newEmptyEntity();
                    // pr($estagiario);
                    // die('estagiario');
                    $dadosinsere['aluno_id'] = $aluno_id;
                    // pr($dadosinsere);
                    // die();
                    $estagiario_aluno_id = $this->Estagiarios->patchEntity($estagiario_aluno_id, $dadosinsere);
                    if ($this->Estagiarios->save($estagiario_aluno_id)):
                        $this->Flash->success(__("Estagiário atualizado"));
                    endif;
                    /** Finaliza a atualizaçao do estagiario com o id do aluno. */
                }
                // die();
                return $this->redirect(['action' => 'termodecompromisso', '?' => ['estudante_id' => $estudante_id]]);
            }
            // debug($estagiario);
            $this->Flash->error(__('Não foi possível finalizar. Tente mais uma vez.'));
        } // Finaliza post

        /** Calculo o periodo atual para estimar o nivel de estágio do Termo de Compromisso. */
        if (!isset($periodoatual) || empty($periodoatual)) {
            $configuracaotabela = $this->fetchTable('Configuracao');
            $periodo = $configuracaotabela->find()->first();
            $periodoatual = $periodo->mural_periodo_atual;
        }

        $this->set('periodo', $periodoatual);

        if ($aluno_id) {
            $ultimoestagio = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Professores', 'Instituicoes'])
                ->where(['Estagiarios.estudante_id' => $aluno_id])
                ->order(['Estagiarios.nivel'])
                ->all()
                ->last();
        }
        // pr($ultimoestagio);
        // die();
        /** Se for um estudante estagiario calculo o ultimo estágio para inserir ou atualizar. */
        if (isset($ultimoestagio)) {
            $teste = $ultimoestagio->periodo == $periodoatual;
            /* Se o periodo atual é o mesmo do periodo cadastrado deixa o nivel como está */
            if ($ultimoestagio->periodo == $periodoatual) {
                // pr("Atualização de dados do estagiario");
                // echo "Atualiza o termo de compromisso";
                $this->set('atualizar', 1);
                // Se o periodo atual é maior que o cadastrado então passa para o próximo nivel e insere um novo registro
            } elseif ($ultimoestagio->periodo < $periodoatual) {
                $ultimoestagio->periodo = $periodoatual;
                // pr($ultimoestagio->nivel);
                /* Calculo o ultimo estagio a partir do ajuste curricular. */
                ($ultimoestagio->ajustecurricular) == 0 ? $ultimonivelestagio = 4 : $ultimonivelestagio = 3;
                // pr($ultimonivelestagio);
                // die();
                /** Se ja esta no ultimo nivel curricular entao esta realizando estagio extracurricular e o nivel e 9. */
                if ($ultimoestagio->nivel >= $ultimonivelestagio) {
                    // Estágio não curricular
                    $ultimoestagio->nivel = 9;
                } else {
                    $ultimoestagio->nivel = $ultimoestagio->nivel + 1;
                }
                // pr($ultimoestagio->nivel);
            } else {
                $this->Flash->error(__("Periodo de estagio atual nao pode ser menor que o ultimo periodo cursado."));
                return $this->redirect(['action' => 'termodecompromisso']);
            }
            // die($ultimoestagio);
            $this->set('estudanteestagiario', $ultimoestagio->Alunos);
            $this->set('ultimoestagio', $ultimoestagio);
        } else {
            // Se não é estagiário então capturo a informação do estudante e envio para o formulario
            // pr($estudante_id);
            // die();

            $estudante_semestagio = $estudantestabela->find()
                ->contain([])
                ->where(['Estudantes.id' => $aluno_id])
                ->select(['id', 'registro', 'nome', 'turno', 'ingresso'])
                ->first();
            $this->set('estudante_semestagio', $estudante_semestagio);
        }

        // pr($ultimoestagio);
        // pr($estudante_semestagio);
        // die();
        /** Para fazer as caixas de seleção */
        /* Supervisores da instituição */
        if ($instituicao_id) {

            $supervisores_instituicao = $this->Estagiarios->Instituicoes->find()
                ->contain(['Supervisores'])
                ->where(['Instituicaoestagios.id' => $instituicao_id])
                ->first();

            // pr($supervisores_instituicao);
            // die();
            $this->set('instituicao_id', $instituicao_id);
            if ($supervisores_instituicao) {
                $this->set('instituicao', $supervisores_instituicao);
                foreach ($supervisores_instituicao->supervisores as $c_supervisor) {
                    $supervisoresdainstituicao[$c_supervisor['id']] = $c_supervisor['nome'];
                }
            } else {
                $supervisoresdainstituicao[0] = "Sem supervisor(a)";
            }
            // pr($supervisoresdainstituicao);
            // die();
            /** Se o id da institucao nao veio como parametro entao o id e o id do $ultimoestagio. */
        } elseif (isset($ultimoestagio->instituicaoestagio->id)) {
            // pr($ultimoestagio->instituicaoestagio->id);
            $supervisores_instituicao = $this->Estagiarios->Instituicoes->find()
                ->contain(['Supervisores'])
                ->where(['Instituicaoestagios.id' => $ultimoestagio->instituicaoestagio->id])
                ->first();
            $this->set('instituicao_id', $ultimoestagio->instituicaoestagio->id);
            if ($supervisores_instituicao) {
                $this->set('instituicao', $supervisores_instituicao);
                foreach ($supervisores_instituicao->supervisores as $c_supervisor) {
                    $supervisoresdainstituicao[$c_supervisor['id']] = $c_supervisor['nome'];
                }
            } else {
                $supervisoresdainstituicao[0] = "Sem supervisor(a)";
            }
            // pr($supervisoresdainstituicao);
        } else {
            $supervisoresdainstituicao[0] = "Sem dados";
        }
        // die();
        if (isset($supervisores_instituicao)) {
            $this->set('supervisores', $supervisores_instituicao->supervisores);
        } else {
            $this->set('supervisores', 'Sem dados');
        }

        $this->set('estudante_id', $estudante_id);
        $estudante = $estudantestabela->find()->where(['Estudantes.id' => $estudante_id])->first();
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $turmaestagios = $this->Estagiarios->Turmestagios->find('list');
        $this->set(compact('instituicoes', 'turmaestagios', 'estudante'));
        if (isset($supervisoresdainstituicao)):
            $this->set('supervisoresdainstituicao', $supervisoresdainstituicao);
        endif;
    }

    /**
     * novotermocompromisso method
     * @param string|null $aluno_id ID do aluno
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function novotermocompromisso($id = NULL)
    {
        $this->viewBuilder()->enableAutoLayout(false);
        $this->Authorization->skipAuthorization();
        $aluno_id = $this->getRequest()->getQuery('aluno_id');
        if ($aluno_id == null) {
            $this->Flash->error(__('Selecionar o aluno para o termo de compromisso'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        } else {
            $estagiario = $this->Estagiarios->find()
                ->where(['aluno_id' => $aluno_id])
                ->order(['nivel' => 'desc'])
                ->first();
            if ($estagiario) {
                /** Compara periodo e se é diferente então aumenta o nivel e adiciona um novo estagiario senão edita o estagiario para atualizar a instituição e o supervisor */
                $configuraperiodoatual = $this->fetchTable('Configuracao')->find()->select('mural_periodo_atual')->first();
                $periodoatual = $configuraperiodoatual->mural_periodo_atual;
                if ($estagiario->periodo == $periodoatual) {
                    return $this->redirect(['controller' => 'Estagiarios', 'action' => 'edit', $estagiario->id]); // Redireciona para a atualização do estagiario
                } else {
                    return $this->redirect(['controller' => 'Estagiarios', 'action' => 'add', '?' => ['aluno_id' => $aluno_id]]);
                }
            } else {
                $this->Flash->success(__('O aluno ainda não é estagiário'));
                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'add', '?' => ['aluno_id' => $aluno_id]]);
            }
        }
    }

    /**
     * termodecompromissopdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
    public function termodecompromissopdf($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->enableAutoLayout(false);
        if (is_null($id)) {
            throw new \Cake\Http\Exception\NotFoundException(__('Sem parâmetros para localizar o estagiário'));
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $id]);
        }
        // pr($estagiario->first());
        // die();
        $configuracao = $this->fetchTable('Configuracao')->find()->where(['Configuracao.id' => 1])->first();
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

    public function selecionadeclaracaodeestagio($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if ($id === null) {
            $this->Flash->error(__('Selecionar o estágio do(a) estudante'));
            return $this->redirect('/Alunos/index');
        } else {
            if ($this->request->getAttribute('categoria') == '2') {
                $estagiario = $this->Estagiarios->find()
                    ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.registro' => $this->request->getAttribute('registro')])
                    ->all();
            }
            //pr($estagiario);
            // die();
        }
        $this->set('estagiario', $estagiario);
    }

    /**
     * declaracaodeestagiopdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
    public function declaracaodeestagiopdf($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $estagiario = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
            ->where(['Estagiarios.id' => $id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Sem estagio cadastrado.'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $id]);
        }

        if (empty($estagiario->aluno->identidade)) {
            $this->Flash->error(__("Estudante sem RG"));
            return $this->redirect('/Alunos/view/' . $estagiario->aluno->id);
        }

        if (empty($estagiario->aluno->orgao)) {
            $this->Flash->error(__("Estudante não especifica o orgão emisor do documento"));
            return $this->redirect('/Alunos/view/' . $estagiario->aluno->id);
        }

        if (empty($estagiario->aluno->cpf)) {
            $this->Flash->error(__("Estudante sem CPF"));
            return $this->redirect('/Alunos/view/' . $estagiario->aluno->id);
        }

        if (empty($estagiario->supervisor->id)) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            return $this->redirect('/Estagiarios/view/' . $estagiario->id);
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
        $this->set('estagiario', $estagiario);
    }

    public function selecionafolhadeatividades($id = NULL)
    {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante e o estágio'));
            return $this->redirect('/Alunos/index');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function folhadeatividadespdf($id = NULL)
    {

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $estagiario = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
        // pr($estagiario);
        // die();
        $this->viewBuilder()->enableAutoLayout(false);

        if ($estagiario) {
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
        } else {
            $this->Flash->error(__('Sem estagiario cadastrado'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'index']);
        }
    }

    public function selecionaavaliacaodiscente($id = NULL)
    {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/Alunos/index');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }


        $this->set('estagiario', $estagiario);
    }

    public function avaliacaodiscentepdf($id = NULL)
    {

        $this->viewBuilder()->disableAutoLayout();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        $estagiario = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Sem estagiarios cadastrados'));
            return $this->redirect(['estagiario' => $estagiario, 'action' => 'view', $estagiario_id]);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'avaliacao_discente_' . $estagiario_id . '.pdf' //// This can be omitted if you want file name based on URL.
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
    public function edit($id = null)
    {

        if ($id === null) {
            $this->Flash->error(__('Sem parâmetro para localizar o estagiário.'));
            throw new \Cake\Http\Exception\NotFoundException(__('Sem parâmetro para localizar o estagiário.'));
        } else {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => [],
            ]);
        }
        $this->Authorization->authorize($estagiario);
        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Registro de estagiario atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro de estagiario nao foi atualizado. Tente novamente.'));
        }

        /** Supervisores da instituição */
        $supervisoresporinstituicao = $this->fetchTable('Instituicoes')->find()
            ->contain(['Supervisores'])
            ->where(['Instituicoes.id' => $estagiario->instituicao_id])
            ->first();
        foreach ($supervisoresporinstituicao->supervisores as $supervisor) {
            $supervisores[$supervisor->id] = $supervisor->nome;
        }
        $alunos = $this->fetchTable('Alunos')->find('list');
        $instituicoes = $this->fetchTable('Instituicoes')->find('list');
        $professores = $this->fetchTable('Professores')->find('list');
        $turamestagios = $this->fetchTable('Turmaestagios')->find('list');
        $this->set(compact('estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'turamestagios'));
        $this->set('turmaestagios', $turamestagios);
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Estagiário excluído.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o estagiário'));
        }

        return $this->redirect(['controller' => 'alunos', 'action' => 'view', '?' => ['registro', $estagiario->registro]]);
    }

    public function lancanota($id = null)
    {

        $siape = $this->getRequest()->getQuery('siape');

        $idquery = $this->Estagiarios->Professores->find()
            ->contain([
                'Estagiarios' => [
                    'sort' => ['periodo' => 'desc'],
                    'Alunos' => ['fields' => ['id', 'nome'], 'sort' => ['nome']],
                    'Professores' => ['fields' => ['id', 'nome', 'siape']],
                    'Supervisores' => ['fields' => ['id', 'nome']],
                    'Instituicoes' => ['fields' => ['id', 'instituicao']],
                    'Avaliacoes' => ['fields' => ['id', 'estagiario_id']]
                ]
            ])
            ->where(['siape' => $siape]);

        // die();
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
                $folhadeatividadestabela = $this->fetchTable('Folhadeatividades');
                $folhaquery = $folhadeatividadestabela->find()
                    ->where(['Folhadeatividades.estagiario_id' => $c_estagio->id]);
                $folha = $folhaquery->first();
                if ($folha):
                    // pr($folha);
                endif;
                $estagiarioslancanota[$i]['instituicao_id'] = $c_estagio->instituicaoestagio->id;
                $estagiarioslancanota[$i]['instituicao'] = $c_estagio->instituicaoestagio->instituicao;
                $estagiarioslancanota[$i]['supervisor_id'] = $c_estagio->supervisor->id;
                $estagiarioslancanota[$i]['supervisora'] = $c_estagio->supervisor->nome;
                $estagiarioslancanota[$i]['professor_id'] = $c_estagio->docente->id;
                $estagiarioslancanota[$i]['docente'] = $c_estagio->docente->nome;
                $estagiarioslancanota[$i]['estudante_id'] = $c_estagio->aluno->id;
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
