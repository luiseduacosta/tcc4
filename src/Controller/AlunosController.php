<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\Table $Estagiarios
 * @property \Cake\ORM\Table $Instituicoes
 * @property \Cake\ORM\Table $Supervisores
 * @property \Cake\ORM\Table $Professores
 *
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

/**
 * AlunosController handles actions related to the management of students (alunos).
 * It provides functionalities for viewing, adding, editing, and deleting students,
 * as well as generating various PDF documents related to student evaluations and activities.
 * The controller also manages the filtering and pagination of student records based on certain criteria.
 */
class AlunosController extends AppController
{
    /**
     * initialize method
     *
     * @return void
     */

    protected $user;

    public function initialize(): void
    {
        parent::initialize();
        $user = $this->getRequest()->getAttribute("identity");
        $this->set("user", $user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($alunos = null)
    {
        $nome = $this->getRequest()->getQuery("nome");
        $dre = $this->getRequest()->getQuery("dre");

        if ($nome) {
            $alunos = $this->Alunos->find()
                ->where(["Alunos.nome LIKE" => "%{$nome}%"])
                ->order(['nome' => 'ASC']);
            $this->Authorization->skipAuthorization();
            if ($alunos->count() === 0) {
                $this->Flash->error(__("Nenhum aluno encontrado com o nome: {$nome}"));
                // die('Nenhum aluno encontrado com o nome: ' . $nome);
                return $this->redirect([
                    "controller" => "Alunos",
                    "action" => "index"
                ]);
            }
        }
        if ($dre) {
            $alunos = $this->Alunos->find()
                ->where(["Alunos.registro" => $dre])
                ->order(['nome' => 'ASC']);
            // debug($alunos);
            // die();
            $this->Authorization->skipAuthorization();
            if ($alunos->count() === 0) {
                $this->Flash->error(__("Nenhum aluno encontrado com o DRE: {$dre}"));
                // die('Nenhum aluno encontrado com o DRE: ' . $dre);
                return $this->redirect([
                    "controller" => "Alunos",
                    "action" => "index"
                ]);
            }
        }
        if (empty($alunos)) {
            $alunos = $this->Alunos->find()->order(['nome' => 'ASC']);
        }

        if ($this->Authorization->skipAuthorization()) {
            // pr($query->all());
            // die();
        } else {
            $this->Flash->error(__("Acesso não autorizado."));
            return $this->redirect([
                "controller" => "Muralestagios",
                "action" => "index",
            ]);
        }

        if ($alunos->count() === 0) {
            $this->Flash->error(__("Nenhum aluno encontrado."));
            return $this->redirect([
                "controller" => "Alunos",
                "action" => "add",
            ]);
        }
        $this->set('alunos', $this->paginate($alunos));
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
        $this->Authorization->skipAuthorization();
        $aluno = $this->Alunos
            ->find()
            ->contain([
                "Estagiarios" => [
                    "Instituicoes",
                    "Alunos",
                    "Supervisores",
                    "Professores",
                    "Turmaestagios",
                ],
                "Muralinscricoes" => ["Muralestagios"],
            ])
            ->where(["Alunos.id" => $id])
            ->first();
        if (empty($aluno)) {
            $this->Flash->error(__("Aluno não encontrado"));
            return $this->redirect(["action" => "index"]);
        }
        try {
            $this->Authorization->authorize($aluno);
            $this->set(compact("aluno"));
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso não autorizado."));
            return $this->redirect(["action" => "index"]);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dre = $this->getRequest()->getQuery("dre");
        $email = $this->getRequest()->getQuery("email");
        $aluno = $this->Alunos->newEmptyEntity();
        try {
            $this->Authorization->authorize($aluno);
            $this->set(compact("aluno"));
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso não autorizado 1."));
            return $this->redirect(["action" => "view", $this->user->estudante_id]);
        }
        if ($this->request->is("post", "put", "patch")) {
            if (
                empty($this->request->getData()["registro"]) ||
                empty($this->request->getData()["email"])
            ) {
                $this->Flash->error(__("DRE e Email são obrigatórios."));
                return $this->redirect(['controller' => 'Users', "action" => "login"]);
            }
            // Verifica se o DRE ou email já estão cadastrados
            $registro = $this->Alunos
                ->find()
                ->where(["registro" => $this->request->getData()["registro"]])
                ->first();

            if ($registro) {
                $this->Flash->error(__("DRE já cadastrado."));
                return $this->redirect(["action" => "view", $registro->id]);
            }

            $email = $this->Alunos
                ->find()
                ->where(["email" => $this->request->getData()["email"]])
                ->first();
            if ($email) {
                $this->Flash->error(__("Email já cadastrado."));
                return $this->redirect(["action" => "view", $email->id]);
            }

            $aluno = $this->Alunos->patchEntity(
                $aluno,
                $this->request->getData(),
            );
            if ($this->Authorization->authorize($aluno)) {

                if ($this->Alunos->save($aluno)) {
                    $this->Flash->success(__("Dados do aluno inseridos."));
                    return $this->redirect(["action" => "view", $aluno->id]);
                }
                $this->Flash->error(__("Dados do aluno não inseridos."));
            }
        }
        if (!empty($dre) && !empty($email)) {
            $aluno->registro = $dre;
            $aluno->email = $email;
        }
        $this->set(compact("aluno"));
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
        $aluno = $this->Alunos->get($id, [
            "contain" => [],
        ]);
        $this->Authorization->authorize($aluno);

        $user = $this->getRequest()->getAttribute("identity");

        if (isset($this->user) && $this->user->categoria == "1") {
            $this->Authorization->authorize($aluno);
        } elseif (isset($user) && $user->categoria == "2") {
            if ($aluno->id == $user->estudante_id) {
                // $this->Authorization->authorize($aluno);
            } else {
                $this->Flash->error(__("Usuário não autorizado."));
                return $this->redirect(["action" => "view", $user->estudante_id]);
            }
        } else {
            $this->Flash->error(__("Operação não autorizada."));
            return $this->redirect(["action" => "index"]);
        }

        if ($this->request->is(["patch", "post", "put"])) {
            $entity = $this->Alunos->patchEntity(
                $aluno,
                $this->request->getData(),
            );
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__("Dados do aluno atualizados."));
                return $this->redirect(["action" => "view", $aluno->id]);
            }
            $this->Flash->error(__("Dados do aluno não atualizados."));
            $debug = $entity->getErrors();
        }

        $this->set(compact("aluno"));
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
        $this->request->allowMethod(["post", "delete"]);
        $aluno = $this->Alunos->get($id);
        $this->Authorization->authorize($aluno);
        $estagiarios = $this->Alunos->Estagiarios
            ->find()
            ->where(["Estagiarios.aluno_id" => $id])
            ->first();
        if ($estagiarios) {
            $this->Flash->error(
                __("Aluno possui estagiários, não pode ser excluído."),
            );
            return $this->redirect(["action" => "view", $id]);
        }
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__("Dados do aluno excluídos."));
            return $this->redirect(["action" => "index"]);
        } else {
            $this->Flash->error(__("Dados do aluno não excluídos."));
            return $this->redirect(["action" => "view", $id]);
        }
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
        ini_set("memory_limit", "2048M");
        $ordem = $this->getRequest()->getQuery("ordem");

        if (empty($ordem)) {
            $ordem = "q_semestres";
        }

        $alunos = $this->Alunos
            ->find()
            ->contain(["Estagiarios"])
            ->limit(20)
            ->toArray();

        if (empty($alunos)) {
            $this->Flash->error(__("Nenhum aluno encontrado."));
            return $this->redirect(["action" => "index"]);
        } else {
            /**
             * Monta um array com a carga horária total de cada aluno
             */
            $criterio[] = null;
            $cargahorariatotal[] = null;
            $i = 0;
            foreach ($alunos as $aluno):
                // pr($aluno);
                $cargahorariatotal[$i]["id"] = $aluno["id"];
                $cargahorariatotal[$i]["registro"] = $aluno["registro"];
                $cargahorariatotal[$i]["q_semestres"] = sizeof(
                    $aluno["estagiarios"],
                );
                $carga_estagio['ch'] = null;
                $y = 0;
                foreach ($aluno["estagiarios"] as $estagiario):
                    // pr($estagiario['ch']);
                    if ($estagiario["nivel"] == 1):
                        $cargahorariatotal[$i][$y]["ch"] = $estagiario["ch"];
                        $cargahorariatotal[$i][$y]["nivel"] = $estagiario["nivel"];
                        $cargahorariatotal[$i][$y]["periodo"] =
                            $estagiario["periodo"];
                        $carga_estagio["ch"] =
                            $carga_estagio["ch"] + $estagiario["ch"];
                    else:
                        $cargahorariatotal[$i][$y]["ch"] = $estagiario["ch"];
                        $cargahorariatotal[$i][$y]["nivel"] = $estagiario["nivel"];
                        $cargahorariatotal[$i][$y]["periodo"] =
                            $estagiario["periodo"];
                        $carga_estagio["ch"] =
                            $carga_estagio["ch"] + $estagiario["ch"];
                    endif;
                    $y++;
                endforeach;
                $cargahorariatotal[$i]["ch_total"] = $carga_estagio["ch"];
                $criterio[$i] = $cargahorariatotal[$i][$ordem];
                $i++;
            endforeach;

            array_multisort($criterio, SORT_ASC, $cargahorariatotal);
            $this->set("cargahorariatotal", $cargahorariatotal);
        }
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
        $user = $this->getRequest()->getAttribute("identity");
        if (isset($user) && $user->categoria == "2") {
            $aluno = $this->Alunos
                ->find()
                ->where(["Alunos.id" => $user->estudante_id])
                ->order(["Alunos.id" => "asc"])
                ->first();
        } elseif (isset($user) && $user->categoria == "1") {
            if ($id === null) {
                $this->Flash->error(
                    __("Operação não pode ser realizada: 'id' não informado."),
                );
                return $this->redirect([
                    "controller" => "Alunos",
                    "action" => "index",
                ]);
            } else {
                $aluno = $this->Alunos
                    ->find()
                    ->where(["Alunos.id" => $id])
                    ->order(["Alunos.id" => "asc"])
                    ->first();
            }
        } else {
            $this->Flash->error(__("Operação não autorizada."));
            return $this->redirect([
                "controller" => "Alunos",
                "action" => "index",
            ]);
        }
        if ($this->request->is(["post", "put"])) {
            $aluno = $this->request->getData();

            $periodoacademicoatual = $this->fetchTable("Configuracoes")
                ->find()
                ->select(["periodo_calendario_academico"])
                ->first();
            /**
             * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
             */
            $periodo_atual =
                $periodoacademicoatual->periodo_calendario_academico;
            /** Capturo o periodo inicial para o cálculo dos semetres.
             *  Inicialmente coincide com o campo de ingresso.
             *  Mas pode ser alterada para fazer coincidir os semestres no casos dos alunos que trancaram.
             */
            $novoperiodo = $aluno["novoperiodo"];
            $periodo_inicial = $novoperiodo ?? $aluno->ingresso;

            $inicial = explode("-", $periodo_inicial);
            $atual = explode("-", $periodo_atual);
            /**
             * Calculo o total de semestres multiplicando o número de anos por 2.
             */
            $semestres = ($atual[0] - $inicial[0] + 1) * 2;
            // pr($semestres);
            // die();
            /** Verifica se o período está completo: ano e semestre */
            if (sizeof($inicial) < 2) {
                $inicial[1] = 0;
                $totalperiodos = $semestres;
                $this->Flash->error(
                    __(
                        "Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre",
                    ),
                );
            }
            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if ($inicial[1] == 1 && $atual[1] == 2) {
                $totalperiodos = $semestres;
            }
            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if ($inicial[1] == 1 && $atual[1] == 1) {
                $totalperiodos = $semestres - 1;
            }
            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if ($inicial[1] == 2 && $atual[1] == 2) {
                $totalperiodos = $semestres - 1;
            }
            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if ($inicial[1] == 2 && $atual[1] == 1) {
                $totalperiodos = $semestres - 2;
            }
            // pr('Total: ' . $totalperiodos);
            // die();
            /** Se o período inicial é maior que o período atual então informar que há um erro */
            if ($totalperiodos <= 0) {
                $this->Flash->error(
                    __("Error: período inicial é maior que período atual"),
                );
                // return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', '?' => ['aluno_id' => $this->getRequest()->getAttribute('identity')['aluno_id']]]);
            }
        }
        $this->set("aluno", $aluno);
    }

    /**
     * Certificado de Período
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function certificadoperiodo($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute("identity");
        $totalperiodos = $this->getRequest()->getQuery("totalperiodos");
        $novoperiodo = $this->getRequest()->getQuery("novoperiodo");

        if (isset($user) && $user->categoria == "2") {
            if ($id == $user->estudante_id) {
                $aluno = $this->Alunos
                    ->find()
                    ->where(["Alunos.id" => $id])
                    ->first();
            } else {
                $this->Flash->error(__("1. Usuário aluno não autorizado."));
                return $this->redirect([
                    "controller" => "Alunos",
                    "action" => "certificadoperiodo",
                    "?" => ["registro" => $user->numero],
                ]);
            }
        } elseif (isset($user) && $user->categoria == "1") {
            if ($id === null) {
                $this->Flash->error(
                    __(
                        "Administrador: operação não pode ser realizada porque o'id' não foi informado.",
                    ),
                );
                return $this->redirect([
                    "controller" => "Alunos",
                    "action" => "index",
                ]);
            } else {
                $aluno = $this->Alunos
                    ->find()
                    ->where(["Alunos.id" => $id])
                    ->first();
            }
        } else {
            $this->Flash->error(__("2. Outros usuários não autorizados."));
            return $this->redirect([
                "controller" => "Muralestagios",
                "action" => "index",
            ]);
        }

        if (strlen($aluno->ingresso) < 6) {
            $this->Flash->error(
                __(
                    "Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre",
                ),
            );
            return $this->redirect([
                "controller" => "Alunos",
                "action" => "view",
                $id,
            ]);
        }

        if ($totalperiodos == null) {
            /** Capturo o periodo do calendario academico atual */
            $periodoacademicoatual = $this->fetchTable("Configuracoes")
                ->find()
                ->select(["periodo_calendario_academico"])
                ->first();

            $periodo_atual =
                $periodoacademicoatual->periodo_calendario_academico;
            $periodo_inicial = $aluno->ingresso;

            $inicial = explode("-", $periodo_inicial);
            $atual = explode("-", $periodo_atual);

            /** Calculo o total de semestres */
            $semestres = ($atual[0] - $inicial[0] + 1) * 2;

            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if ($inicial[1] == 1 && $atual[1] == 2) {
                $totalperiodos = $semestres;
            }

            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if ($inicial[1] == 1 && $atual[1] == 1) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if ($inicial[1] == 2 && $atual[1] == 2) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if ($inicial[1] == 2 && $atual[1] == 1) {
                $totalperiodos = $semestres - 2;
            }
        }

        if ($this->request->is(["post", "put"])) {
            $aluno = $this->request->getData();
            /**
             * Calculo a partir do ingresso em que periodo o aluno esté neste momento.
             */
            /* Capturo o periodo do calendario academico atual */
            $periodoacademicoatual = $this->fetchTable("Configuracoes")
                ->find()
                ->select(["periodo_calendario_academico"])
                ->first();
            /**
             * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
             */
            $periodo_atual =
                $periodoacademicoatual->periodo_calendario_academico;
            /** Capturo o periodo inicial para o cálculo dos semetres.
             *  Inicialmente coincide com o campo de ingresso.
             *  Mas pode ser alterada para fazer coincidir os semestres no casos dos alunos que trancaram.
             */
            $novoperiodo = $this->getRequest()->getData("novoperiodo");
            if (strlen($novoperiodo) < 6) {
                $this->Flash->error(
                    __(
                        "Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre",
                    ),
                );
                if (
                    isset(
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ]
                ) &&
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ] == "2"
                ) {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        "?" => [
                            "aluno_id" => $this->getRequest()->getAttribute(
                                "identity",
                            )["estudante_id"],
                        ],
                    ]);
                } else {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        $id,
                    ]);
                }
            }
            if (strlen($aluno->ingresso) < 6) {
                $this->Flash->error(
                    __(
                        "Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre",
                    ),
                );
                if (
                    isset(
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ]
                ) &&
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ] == "2"
                ) {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        "?" => [
                            "aluno_id" => $this->getRequest()->getAttribute(
                                "identity",
                            )["estudante_id"],
                        ],
                    ]);
                } else {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        $id,
                    ]);
                }
            }
            if ($novoperiodo) {
                $periodo_inicial = $novoperiodo;
            } else {
                $periodo_inicial = $aluno["ingresso"];
            }

            $inicial = explode("-", $periodo_inicial);
            $atual = explode("-", $periodo_atual);

            /**
             * Calculo o total de semestres
             */
            $semestres = ($atual[0] - $inicial[0] + 1) * 2;

            /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
            if ($inicial[1] == 1 && $atual[1] == 2) {
                $totalperiodos = $semestres;
            }

            /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
            if ($inicial[1] == 1 && $atual[1] == 1) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
            if ($inicial[1] == 2 && $atual[1] == 2) {
                $totalperiodos = $semestres - 1;
            }

            /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
            if ($inicial[1] == 2 && $atual[1] == 1) {
                $totalperiodos = $semestres - 2;
            }

            /** Se o período inicial é maior que o período atual então informar que há um erro */
            if ($totalperiodos <= 0) {
                $this->Flash->error(
                    __("Error: período inicial é maior que período atual"),
                );
                if (
                    isset(
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ]
                ) &&
                    $this->getRequest()->getAttribute("identity")[
                        "categoria"
                    ] == "2"
                ) {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        $this->getRequest()->getAttribute("identity")[
                            "estudante_id"
                        ],
                    ]);
                } else {
                    return $this->redirect([
                        "controller" => "Alunos",
                        "action" => "certificadoperiodo",
                        $id,
                    ]);
                }
            }

            if (isset($this->getRequest()->getData()["novoperiodo"])) {
                $novoperiodo = $this->getRequest()->getData()["novoperiodo"];
            } else {
                $novoperiodo = $aluno["ingresso"];
            }
            return $this->redirect([
                "controller" => "Alunos",
                "action" => "certificadoperiodo",
                $id,
                "?" => [
                    "totalperiodos" => $totalperiodos,
                    "novoperiodo" => $novoperiodo,
                ],
            ]);
        }

        $this->set("aluno", $aluno);
        $this->set("totalperiodos", $totalperiodos);
        $this->set("novoperiodo", $novoperiodo);
    }

    /**
     * Certificado de Período PDF
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function certificadoperiodopdf($id = null)
    {
        $this->Authorization->skipAuthorization();
        $id = $this->getRequest()->getQuery("id");
        $totalperiodos = $this->getRequest()->getQuery("totalperiodos");

        if ($id === null) {
            throw new \Cake\Http\Exception\NotFoundException(
                __("Parametro id não encontrado."),
            );
        } else {
            $aluno = $this->Alunos
                ->find()
                ->contain([])
                ->where(["Alunos.id" => $id])
                ->first();
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName("CakePdf.Pdf");
        $this->viewBuilder()->setOption("pdfConfig", [
            "orientation" => "portrait",
            "download" => true, // This can be omitted if "filename" is specified.
            "filename" => "declaracao_de_periodo_" . $id . ".pdf", //// This can be omitted if you want file name based on URL.
        ]);

        $this->set("aluno", $aluno);
        $this->set("totalperiodos", $totalperiodos);
    }

    /**
     * Planilha de CRESS
     *
     * @param string|null $periodo Período.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function planilhacress($id = null)
    {
        $this->Authorization->skipAuthorization();
        $periodo = $this->getRequest()->getQuery("periodo") ?: null;
        $ordem = "Alunos.nome";

        /* Todos os periódos */
        $periodototal = $this->Alunos->Estagiarios->find("list", [
            "keyField" => "periodo",
            "valueField" => "periodo",
            "order" => ["periodo" => "desc"],
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio anexo como parametro então o período é o último da lista dos períodos */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $cress = $this->Alunos->Estagiarios
            ->find()
            ->contain(["Alunos", "Instituicoes", "Supervisores", "Professores"])
            ->select([
                "Estagiarios.periodo",
                "Alunos.id",
                "Alunos.nome",
                "Instituicoes.id",
                "Instituicoes.instituicao",
                "Instituicoes.cep",
                "Instituicoes.endereco",
                "Instituicoes.bairro",
                "Supervisores.nome",
                "Supervisores.cress",
                "Professores.nome",
            ])
            ->where(["Estagiarios.periodo" => $periodo])
            ->order(["Alunos.nome"])
            ->all();

        $this->set("cress", $cress);
        $this->set("periodos", $periodos);
        $this->set("periodoselecionado", $periodo);
    }

    /**
     * Planilha de Seguro
     *
     * @param string|null $periodo Período.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function planilhaseguro($id = null)
    {
        $this->Authorization->skipAuthorization();
        $periodo = $this->getRequest()->getQuery("periodo");

        $ordem = "nome";

        $periodototal = $this->Alunos->Estagiarios->find("list", [
            "keyField" => "periodo",
            "valueField" => "periodo",
            "order" => ["periodo" => "desc"],
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguro = $this->Alunos->Estagiarios
            ->find()
            ->contain(["Alunos", "Instituicoes"])
            ->where(["Estagiarios.periodo" => $periodo])
            ->select([
                "Alunos.id",
                "Alunos.nome",
                "Alunos.cpf",
                "Alunos.nascimento",
                "Alunos.registro",
                "Estagiarios.id",
                "Estagiarios.nivel",
                "Estagiarios.ajuste2020",
                "Estagiarios.periodo",
                "Instituicoes.instituicao",
            ])
            ->order(["Estagiarios.nivel" => "asc"])
            ->all();

        $i = 0;
        foreach ($seguro as $c_seguro) {
            /** Calcula quando iniciou o estágio para cada nivel */
            $semestre = explode("-", $c_seguro->periodo);
            $ano = $semestre[0];
            $indicasemestre = $semestre[1];

            if ($c_seguro->nivel == 1) {
                // Início
                $inicio = $c_seguro->periodo;
            } elseif ($c_seguro->nivel == 2) {
                // Início
                switch ($indicasemestre) {
                    case 1:
                        $novoano = $ano - 1;
                        $inicio = $novoano . "-" . 2;
                        break;
                    case 2:
                        $novoano = $ano - 1;
                        $inicio = $novoano . "-" . 1;
                        break;
                }
            } elseif ($c_seguro->nivel == 3) {
                // Início
                switch ($indicasemestre) {
                    case 1:
                        $novoano = $ano - 2;
                        $inicio = $novoano . "-" . 2;
                        break;
                    case 2:
                        $novoano = $ano - 1;
                        $inicio = $novoano . "-" . 1;
                        break;
                }
            } elseif ($c_seguro->nivel == 4) {
                // Início
                switch ($indicasemestre) {
                    case 1:
                        $novoano = $ano - 2;
                        $inicio = $novoano . "-" . 2;
                        break;
                    case 2:
                        $novoano = $ano - 1;
                        $inicio = $novoano . "-" . 1;
                        break;
                }

                // Estagio não obrigatório. Conto como estágio 9
            } elseif ($c_seguro->nivel == 9) {
                // Início
                switch ($indicasemestre) {
                    case 1:
                        $novoano = $ano - 2;
                        $inicio = $novoano . "-" . 1;
                        break;
                    case 2:
                        $novoano = $ano - 2;
                        $inicio = $novoano . "-" . 2;
                        break;
                }
            }

            // Final = $inicio + 3 ou 4 semestres
            $iniciodoestagio = explode("-", $inicio);
            $anoinicio = $iniciodoestagio[0];
            $semestreinicio = $iniciodoestagio[1];
            if ($c_seguro->ajuste2020 == 0) {
                // 4 semestres de estágio
                if ($semestreinicio == 1) {
                    $final = $anoinicio + 1 . "-" . 2;
                } elseif ($semestreinicio == 2) {
                    $final = $anoinicio + 2 . "-" . 1;
                }
            } elseif ($c_seguro->ajuste2020 == 1) {
                // 3 semestres de estágio
                if ($semestreinicio == 1) {
                    $final = $anoinicio + 1 . "-" . 1;
                } elseif ($semestreinicio == 2) {
                    $final = $anoinicio + 1 . "-" . 2;
                }
            }

            $t_seguro[$i]["id"] = $c_seguro->aluno->id;
            $t_seguro[$i]["estagiario_id"] = $c_seguro->id;
            $t_seguro[$i]["nome"] = $c_seguro->aluno->nome;
            $t_seguro[$i]["cpf"] = $c_seguro->aluno->cpf;
            $t_seguro[$i]["nascimento"] = isset($c_seguro->aluno->nascimento)
                ? $c_seguro->aluno->nascimento->i18nFormat("dd-MM-yyyy")
                : "";
            $t_seguro[$i]["sexo"] = "";
            $t_seguro[$i]["registro"] = $c_seguro->aluno->registro;
            $t_seguro[$i]["curso"] = "UFRJ/Serviço Social";
            if ($c_seguro->nivel == 9):
                $t_seguro[$i]["nivel"] = "Não obrigatório";
            else:
                $t_seguro[$i]["nivel"] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]["ajuste2020"] = $c_seguro->ajuste2020;
            $t_seguro[$i]["periodo"] = $c_seguro->periodo;
            $t_seguro[$i]["inicio"] = $inicio;
            $t_seguro[$i]["final"] = $final;
            $t_seguro[$i]["instituicao"] =
                $c_seguro->instituicao->instituicao ?? "Sem informação";
            $criterio[$i] = $t_seguro[$i]["nome"];

            $i++;
        }

        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        $this->set("t_seguro", $t_seguro);
        $this->set("periodos", $periodos);
        $this->set("periodoselecionado", $periodo);
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
        $this->request->allowMethod(["ajax"]);

        $id = $this->request->getData("id");

        $estagiario = $this->Alunos->Estagiarios
            ->find("all")
            ->where(["Estagiarios.aluno_id" => $id])
            ->order(["Estagiarios.nivel" => "desc"])
            ->first();

        $configuracao = $this->fetchTable("Configuracao")
            ->find()
            ->select(["Configuracao.mural_periodo_atual"])
            ->first();
        $periodoatual = $configuracao->mural_periodo_atual;

        if ($estagiario) {
            if ($periodoatual > $estagiario->periodo) {
                $nivel = $estagiario->nivel + 1;
                switch ($estagiario->ajuste2020) {
                    case 1:
                        if ($nivel > 3) {
                            $nivel = 9;
                        }
                        break;
                    case 0:
                        if ($nivel > 4) {
                            $nivel = 9;
                        }
                        break;
                    default:
                        $nivel;
                        break;
                }
            } else {
                $nivel = $estagiario->nivel;
            }
            $estagiario->nivel = $nivel;
            return $this->response
                ->withType("application/json")
                ->withStringBody(json_encode($estagiario));
        } else {
            return $this->response
                ->withType("application/json")
                ->withStatus(404)
                ->withStringBody(
                    json_encode(["error" => "Estagiário não encontrado"]),
                );
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
        $this->request->allowMethod(["ajax"]);

        $id = $this->request->getData("id");

        try {
            $configuracao = $this->fetchTable("Configuracao")
                ->find()
                ->select(["Configuracao.mural_periodo_atual"])
                ->first();
            $periodoatual = $configuracao->mural_periodo_atual;

            $aluno = $this->Alunos->Estagiarios
                ->find()
                ->where(["Estagiarios.aluno_id" => $id])
                ->order(["Estagiarios.nivel" => "desc"])
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
                    ->withType("application/json")
                    ->withStringBody(json_encode($aluno));
            } else {
                return $this->response
                    ->withType("application/json")
                    ->withStatus(404)
                    ->withStringBody(
                        json_encode(["error" => "Aluno não encontrado"]),
                    );
            }
        } catch (\Exception $e) {
            return $this->response
                ->withType("application/json")
                ->withStatus(500)
                ->withStringBody(
                    json_encode(["error" => "Erro ao buscar aluno"]),
                );
        }
    }

    /**
     * Busca aluno por registro
     * @param string|null $registro Aluno registro.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function buscaalunoregistro($registro = null)
    {
        $this->Authorization->skipAuthorization();
        $registro = $this->request->getData("registro");
        if ($registro) {
            return $this->redirect(["controller" => "Alunos", "action" => "index", "?" => ["dre" => $registro]]);
        } else {
            $this->Flash->error(__("Digite um número de registro para busca"));
            return $this->redirect(["controller" => "Alunos", "action" => "index"]);
        }

    }

    /**
     * Busca aluno por nome
     * @param string|null $nome Aluno nome.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function buscaalunonome($nome = null)
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->request->getData("nome");
        // pr($nome);
        // die();
        if ($nome) {
            // $this->set("nome", trim($nome));
            return $this->redirect(["controller" => "Alunos", "action" => "index", "?" => ["nome" => $nome]]);
        } else {
            $this->Flash->error(__("Digite um nome para busca"));
            return $this->redirect(["controller" => "Alunos", "action" => "index"]);
        }
    }
}
