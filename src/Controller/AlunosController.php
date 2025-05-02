<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *  
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $alunos = $this->paginate($this->Alunos);
        $this->Authorization->skipAuthorization();
        $this->set(compact('alunos'));
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /** Corrigir autorização */
        $this->Authorization->skipAuthorization();

        if ($id === null) {
            $registro = $this->getRequest()->getQuery('registro');
            if (empty($registro)) {
                echo "Sem parâmentros para localizar o aluno";
                $this->Flash->error(__('1. Sem parâmentros para localizar o/a aluno/a?'));
                return $this->redirect('/alunos/index');
            }
            $aluno = $this->Alunos->find()
                ->where(['registro' => $registro])
                ->select('alunos.id')
                ->first();

            if (empty($aluno)) {
                echo "Sem parámentros para localizar o aluno";
                $this->Flash->error(__('2. Sem parámentros para localizar o/a aluno/a?'));
                return $this->redirect('/alunos/index');
            } else {
                $id = $aluno->id;
            }
        }
        // $this->Authorization->authorize($aluno);
        $aluno = $this->Alunos->get($id, [
            'contain' => ['Estagiarios' => ['Instituicoes', 'Alunos', 'Supervisores', 'Professores', 'Turmaestagios'], 'Muralinscricoes' => 'Muralestagios']
        ]);
        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $aluno = $this->Alunos->newEmptyEntity();
        $this->Authorization->authorize($aluno);

        if ($this->request->is('post')) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('Dados do aluno inseridos.'));

                return $this->redirect(['action' => 'view', $aluno->id]);
            }
            $this->Flash->error(__('Dados do aluno não inseridos.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $this->Authorization->skipAuthorization();
        $aluno = $this->Alunos->get($id, [
            'contain' => [],
        ]);
        $user = $this->getRequest()->getAttribute('identity');

        if (isset($user) && $user->categoria == '1') {
            $this->Authorization->authorize($aluno);
        } elseif (isset($user) && $user->categoria == '2') {
            if ($aluno->id == $user->estudante_id) {
                // $this->Authorization->authorize($aluno);
            } else {
                $this->Flash->error(__('Usuário não autorizado.'));
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->error(__('Operação não autorizada.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('Dados do aluno atualizados.'));

                return $this->redirect(['action' => 'view', $aluno->id]);
            }
            $this->Flash->error(__('Dados do aluno não atualizados.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $aluno = $this->Alunos->get($id);
        $this->Authorization->authorize($aluno);
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('Dados do aluno excluídos.'));
        } else {
            $this->Flash->error(__('Dados do aluno não excluídos.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Carga Horária
     *
     * @param string|null $ordem Ordem.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function cargahoraria($ordem = null)
    {
        $this->Authorization->skipAuthorization();
        /** Aumenta a memória */
        ini_set('memory_limit', '2048M');
        $ordem = $this->getRequest()->getQuery('ordem');

        if (empty($ordem)) {
            $ordem = 'q_semestres';
        }

        $alunos = $this->Alunos->find()
            ->contain(['Estagiarios'])
            ->limit(20)
            ->toArray();

        $i = 0;
        foreach ($alunos as $aluno):
            $cargahorariatotal[$i]['id'] = $aluno['Aluno']['id'];
            $cargahorariatotal[$i]['registro'] = $aluno['Aluno']['registro'];
            $cargahorariatotal[$i]['q_semestres'] = sizeof($aluno['estagiarios']);
            $carga_estagio = null;
            $y = 0;
            foreach ($aluno['estagiarios'] as $estagiario):
                if ($estagiario['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $estagiario['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $estagiario['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $estagiario['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $estagiario['ch'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $estagiario['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $estagiario['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $estagiario['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $estagiario['ch'];
                endif;
                $y++;
            endforeach;
            $cargahorariatotal[$i]['ch_total'] = $carga_estagio['ch'];
            $criterio[$i] = $cargahorariatotal[$i][$ordem];
            $i++;
        endforeach;

        array_multisort($criterio, SORT_ASC, $cargahorariatotal);
        $this->set('cargahorariatotal', $cargahorariatotal);
    }

    /**
     * Declaração de Período (ob)
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function declaracaoperiodo($id = null)
    {

        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == '2') {
            $aluno = $this->Alunos->find()->where(['Alunos.id' => $user->estudante_id])->order(['Alunos.id' => 'asc'])->first();
        } elseif (isset($user) && $user->categoria == '1') {
            if ($id === null) {
                $this->Flash->error(__("Operação não pode ser realizada: 'id' não informado."));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            } else {
                $aluno = $this->Alunos->find()->where(['Alunos.id' => $id])->order(['Alunos.id' => 'asc'])->first();
            }
        } else {
            $this->Flash->error(__('Operação não autorizada.'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $aluno = $this->request->getData();

            $periodoacademicoatual = $this->fetchTable('Configuracoes')
                ->find()->select(['periodo_calendario_academico'])
                ->first();
            /**
             * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
             */
            $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
            /** Capturo o periodo inicial para o cálculo dos semetres.
             *  Inicialmente coincide com o campo de ingresso.
             *  Mas pode ser alterada para fazer coincidir os semestres no casos dos alunos que trancaram.
             */
            $novoperiodo = $aluno['novoperiodo'];
            $periodo_inicial = $novoperiodo ?? $aluno->ingresso;

            $inicial = explode('-', $periodo_inicial);
            $atual = explode('-', $periodo_atual);
            /**
             * Calculo o total de semestres multiplicando o número de anos por 2.
             */
            $semestres = (($atual[0] - $inicial[0]) + 1) * 2;
            // pr($semestres);
            // die();
            /** Verifica se o período está completo: ano e semestre */
            if (sizeof($inicial) < 2) {
                $inicial[1] = 0;
                $totalperiodos = $semestres;
                $this->Flash->error(__('Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre'));
            }
            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if (($inicial[1] == 1) && ($atual[1] == 2)) {
                $totalperiodos = $semestres;
            }
            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if (($inicial[1] == 1) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 1;
            }
            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if (($inicial[1] == 2) && ($atual[1] == 2)) {
                $totalperiodos = $semestres - 1;
            }
            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if (($inicial[1] == 2) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 2;
            }
            // pr('Total: ' . $totalperiodos);
            // die();            
            /** Se o período inicial é maior que o período atual então informar que há um erro */
            if ($totalperiodos <= 0) {
                $this->Flash->error(__('Error: período inicial é maior que período atual'));
                // return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', '?' => ['aluno_id' => $this->getRequest()->getAttribute('identity')['aluno_id']]]);
            }
        }
        $this->set('aluno', $aluno);

    }

    /**
     * Certificado de Período
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function certificadoperiodo($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        $totalperiodos = $this->getRequest()->getQuery('totalperiodos');
        $novoperiodo = $this->getRequest()->getQuery('novoperiodo');

        if (isset($user) && $user->categoria == '2') {
            if ($id == $user->estudante_id) {
                $aluno = $this->Alunos->find()->where(['Alunos.id' => $id])->first();
            } else {
                $this->Flash->error(__('1. Usuário aluno não autorizado.'));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo?registro=' . $user->numero]);
            }
        } elseif (isset($user) && $user->categoria == '1') {
            if ($id === null) {
                $this->Flash->error(__("Administrador: operação não pode ser realizada porque o'id' não foi informado."));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            } else {
                $aluno = $this->Alunos->find()->where(['Alunos.id' => $id])->first();
            }
        } else {
            $this->Flash->error(__('2. Outros usuários não autorizados.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if (strlen($aluno->ingresso) < 6) {
            $this->Flash->error(__('Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $id]);
        }

        if ($totalperiodos == null) {
            /** Capturo o periodo do calendario academico atual */
            $periodoacademicoatual = $this->fetchTable('Configuracoes')
                ->find()
                ->select(['periodo_calendario_academico'])
                ->first();

            $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
            $periodo_inicial = $aluno->ingresso;

            $inicial = explode('-', $periodo_inicial);
            $atual = explode('-', $periodo_atual);

            /** Calculo o total de semestres */
            $semestres = (($atual[0] - $inicial[0]) + 1) * 2;

            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if (($inicial[1] == 1) && ($atual[1] == 2)) {
                $totalperiodos = $semestres;
            }

            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if (($inicial[1] == 1) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if (($inicial[1] == 2) && ($atual[1] == 2)) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if (($inicial[1] == 2) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 2;
            }
        }

        if ($this->request->is(['post', 'put'])) {

            $aluno = $this->request->getData();
            /**
             * Calculo a partir do ingresso em que periodo o aluno esté neste momento.
             */
            /* Capturo o periodo do calendario academico atual */
            $periodoacademicoatual = $this->fetchTable('Configuracoes')
                ->find()
                ->select(['periodo_calendario_academico'])
                ->first();
            /**
             * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
             */
            $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
            /** Capturo o periodo inicial para o cálculo dos semetres.
             *  Inicialmente coincide com o campo de ingresso.
             *  Mas pode ser alterada para fazer coincidir os semestres no casos dos alunos que trancaram.
             */
            $novoperiodo = $this->getRequest()->getData('novoperiodo');
            if (strlen($novoperiodo) < 6) {
                $this->Flash->error(__('Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre'));
                if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == '2') {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $this->getRequest()->getAttribute('identity')['estudante_id']]);
                } else {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id]);
                }
            }
            if (strlen($aluno->ingresso) < 6) {
                $this->Flash->error(__('Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre'));
                if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == '2') {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $this->getRequest()->getAttribute('identity')['estudante_id']]);
                } else {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id]);
                }
            }
            if ($novoperiodo) {
                $periodo_inicial = $novoperiodo;
            } else {
                $periodo_inicial = $aluno['ingresso'];
            }

            $inicial = explode('-', $periodo_inicial);
            $atual = explode('-', $periodo_atual);

            /**
             * Calculo o total de semestres
             */
            $semestres = (($atual[0] - $inicial[0]) + 1) * 2;

            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if (($inicial[1] == 1) && ($atual[1] == 2)) {
                $totalperiodos = $semestres;
            }

            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if (($inicial[1] == 1) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if (($inicial[1] == 2) && ($atual[1] == 2)) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if (($inicial[1] == 2) && ($atual[1] == 1)) {
                $totalperiodos = $semestres - 2;
            }

            /** Se o período inicial é maior que o período atual então informar que há um erro */
            if ($totalperiodos <= 0) {
                $this->Flash->error(__('Error: período inicial é maior que período atual'));
                if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == '2') {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $this->getRequest()->getAttribute('identity')['estudante_id']]);
                } else {
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id]);
                }
            }

            if (isset($this->getRequest()->getData()['novoperiodo'])) {
                $novoperiodo = $this->getRequest()->getData()['novoperiodo'];
            } else {
                $novoperiodo = $aluno['ingresso'];
            }
            return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id, '?' => ['totalperiodos' => $totalperiodos, 'novoperiodo' => $novoperiodo]]);

        }

        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
        $this->set('novoperiodo', $novoperiodo);
        
    }

    /**
     * Certificado de Período PDF
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function certificadoperiodopdf($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $id = $this->getRequest()->getQuery('id');
        $totalperiodos = $this->getRequest()->getQuery('totalperiodos');

        if ($id === null) {
            throw new \Cake\Http\Exception\NotFoundException(__('Parametro id não encontrado.'));
        } else {
            $aluno = $this->Alunos->find()
                ->contain([])
                ->where(['Alunos.id' => $id])
                ->first();
        }
        // pr($id);
        // pr($totalperiodos);
        // pr($aluno);
        // die('aluno');

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'declaracao_de_periodo_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );

        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
    }

    /**
     * Planilha de CRESS
     *
     * @param string|null $periodo Período.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function planilhacress($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $periodo = $this->getRequest()->getQuery('periodo') ?: NULL;
        $ordem = 'Alunos.nome';

        /* Todos os periódos */
        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio anexo como parametro então o período é o último da lista dos períodos */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $cress = $this->Alunos->Estagiarios->find()
            ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores'])
            ->select(['Estagiarios.periodo', 'Alunos.id', 'Alunos.nome', 'Instituicoes.id', 'Instituicoes.instituicao', 'Instituicoes.cep', 'Instituicoes.endereco', 'Instituicoes.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Professores.nome'])
            ->where(['Estagiarios.periodo' => $periodo])
            ->order(['Alunos.nome'])
            ->all();

        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
    }

    /**
     * Planilha de Seguro
     *
     * @param string|null $periodo Período.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function planilhaseguro($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'nome';

        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => ['periodo' => 'desc']
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguro = $this->Alunos->Estagiarios->find()
            ->contain(['Alunos', 'Instituicoes'])
            ->where(['Estagiarios.periodo' => $periodo])
            ->select([
                'Alunos.id',
                'Alunos.nome',
                'Alunos.cpf',
                'Alunos.nascimento',
                'Alunos.registro',
                'Estagiarios.id',
                'Estagiarios.nivel',
                'Estagiarios.periodo',
                'Instituicoes.instituicao'
            ])
            ->order(['Estagiarios.nivel'])
            ->all();

        $i = 0;
        foreach ($seguro as $c_seguro) {
            if ($c_seguro->nivel == 1) {

                // Início
                $inicio = $c_seguro->periodo;

                // Final
                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $novoindicasemestre = $indicasemestre + 1;
                    $final = $novoano . "-" . $novoindicasemestre;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 2;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro->nivel == 2) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $novoano = $ano - 1;
                    $inicio = $novoano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $inicio = $ano . "-" . "1";
                }

                // Final
                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . "2";
                }
            } elseif ($c_seguro->nivel == 3) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                $novoano = $ano - 1;
                $inicio = $novoano . "-" . $indicasemestre;

                // Final
                if ($indicasemestre == 1) {
                    // $ano = $ano + 1;
                    $final = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro->nivel == 4) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 1;
                    $inicio = $ano . "-" . 1;
                }

                // Final
                $final = $c_seguro->periodo;

                // Estagio não obrigatório. Conto como estágio 9
            } elseif ($c_seguro->nivel == 9) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                }

                // Final
                $final = $c_seguro->periodo;

            }

            $t_seguro[$i]['id'] = $c_seguro->aluno->id;
            $t_seguro[$i]['estagiario_id'] = $c_seguro->id;
            $t_seguro[$i]['nome'] = $c_seguro->aluno->nome;
            $t_seguro[$i]['cpf'] = $c_seguro->aluno->cpf;
            $t_seguro[$i]['nascimento'] = $c_seguro->aluno->nascimento ? $c_seguro->aluno->nascimento->i18nFormat('dd-MM-yyyy') : '';
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro->aluno->registro;
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro->nivel == 9):
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                $t_seguro[$i]['nivel'] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro->periodo;
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = isset($c_seguro->instituicao->instituicao) ? $c_seguro->instituicao->instituicao : 'Sem informação';
            $criterio[$i] = $t_seguro[$i]['nome'];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
    }

    /**
     * Busca estagiário por id
     *
     * @param string|null $id Estagiário id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function buscaestagiario($id = null)
    {
        $this->viewBuilder()->disableAutoLayout();
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['ajax']);

        $id = $this->request->getData('id');

        $estagiario = $this->Alunos->Estagiarios->find(
            'all',
        )
            ->where(['Estagiarios.aluno_id' => $id])
            ->order(['Estagiarios.nivel' => 'desc'])
            ->first();

        $configuracao = $this->fetchTable('Configuracao')->find()
            ->select(['Configuracao.mural_periodo_atual'])
            ->first();
        $periodoatual = $configuracao->mural_periodo_atual;

        if ($estagiario) {
            if ($periodoatual > $estagiario->periodo) {
                $nivel = $estagiario->nivel + 1;
                if ($estagiario->ajuste2020 == 1) {
                    if ($nivel > 3) {
                        $nivel = 9;
                    }
                } elseif ($estagiario->ajuste2020 == 0) {
                    if ($nivel > 4) {
                        $nivel = 9;
                    }
                } else {
                    $nivel;
                }
            } else {
                $nivel = $estagiario->nivel;
            }
            $estagiario->nivel = $nivel;
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($estagiario));

        } else {
            return $this->response
                ->withType('application/json')
                ->withStatus(404)
                ->withStringBody(json_encode(['error' => 'Estagiário não encontrado']));
        }
    }

    /**
     * Busca aluno por id
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getaluno($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['ajax']);

        $id = $this->request->getData('id');

        try {

            $configuracao = $this->fetchTable('Configuracao')->find()
                ->select(['Configuracao.mural_periodo_atual'])
                ->first();
            $periodoatual = $configuracao->mural_periodo_atual;

            $aluno = $this->Alunos->Estagiarios->find()
                ->where(['Estagiarios.aluno_id' => $id])
                ->order(['Estagiarios.nivel' => 'desc'])
                ->first();

            if ($aluno) {
                if ($periodoatual > $aluno->periodo) {
                    $nivel = $aluno->nivel + 1;
                    if ($aluno->ajuste2020 == 1) {
                        if ($nivel > 3) {
                            $nivel = 9;
                        }
                    } elseif ($aluno->ajuste2020 == 0) {
                        if ($nivel > 4) {
                            $nivel = 9;
                        }
                    } else {
                        $nivel;
                    }
                } else {
                    $nivel = $aluno->nivel;
                }
                $aluno->nivel = $nivel;

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($aluno));

            } else {
                return $this->response
                    ->withType('application/json')
                    ->withStatus(404)
                    ->withStringBody(json_encode(['error' => 'Aluno não encontrado']));
            }

        } catch (\Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStatus(500)
                ->withStringBody(json_encode(['error' => 'Erro ao buscar aluno']));
        }
    }

}