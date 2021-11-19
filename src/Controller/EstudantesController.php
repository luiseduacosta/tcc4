<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estudantes Controller
 *
 * @property \App\Model\Table\EstudantesTable $Estudantes
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstudantesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        $estudantes = $this->paginate($this->Estudantes);
        $this->Authorization->authorize($this->Estudantes);
        $this->set(compact('estudantes'));
    }

    /**
     * View method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        if (!$id) {
            $registro = $this->getRequest()->getQuery('registro');
            // pr($registro);
            if ($registro) {
                $estudante = $this->Estudantes->find()->select('id')->where(['registro' => $registro]);
                if (!$estudante->first()) {
                    $this->Flash->error(__('Selecionar estudante'));
                    return $this->redirect('/estudantes/index');
                } else {
                    $id = $estudante->first()->id;
                }
            } else {
                $this->Flash->error(__('Registro não localizado'));
                return $this->redirect('/Estudantes/index');
            }
        }
        // pr($id);
        // die();
        $estudante = $this->Estudantes->get($id, [
            'contain' => ['Estagiarios' => ['Instituicaoestagios', 'Alunos', 'Estudantes', 'Supervisores', 'Docentes', 'Areaestagios'], 'Muralinscricoes' => 'Muralestagios'],
        ]);
        $this->Authorization->authorize($estudante);
        // pr($estudante);
        // die();
        $this->set(compact('estudante'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL) {

        $registro = $this->getRequest()->getQuery('registro');
        $email = $this->getRequest()->getQuery('email');

        $estudante = $this->Estudantes->newEmptyEntity();
        $this->Authorization->authorize($estudante);

        /* Verifico se já está cadastrado */
        if ($this->request->getData('registro')):
            $estudantequery = $this->Estudantes->find()->where(['registro' => $this->request->getData('registro')]);
            $estudantecadastrado = $estudantequery->first();
            if ($estudantecadastrado):
                return $this->redirect(['view' => $estudantecadastrado->id]);
            endif;
        endif;

        if ($this->request->is('post')) {

            /* Verifico se já é um usuário cadastrado */
            $registroestudante = $this->request->getData('registro');
            $user = $this->Estudantes->Userestagios->find()->where(['numero' => $registroestudante]);
            $userdados = $user->first();
            if (empty($userdados)):
                $this->Flash->error(__('Estudante naõ cadastrado como usuário'));
                return $this->redirect('/userestagios/add');
            endif;
            // die();
            $estudante = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            if ($this->Estudantes->save($estudante)) {
                // $this->Flash->success(__('Estudante cadastrado.'));
                $estudanteultimo_id = $this->Estudantes->find()->orderDesc('id')->first();
                // pr($estudanteultimo_id->id);
                // die('estudanteultimo_id');

                /* Verifico se está preenchido o campo estudante_id */
                $userquery = $this->Estudantes->Userestagios->find()->where(['numero' => $estudanteultimo_id->registro]);
                $userestagios = $userquery->first();
                $userdados = $userestagios->toArray();

                if (empty($userdados['estudante_id'])) {
                    $userdados['estudante_id'] = $estudanteultimo_id->id;
                    $this->loadModel('Userestagios');
                    $userestagios = $this->Userestagios->patchEntity($userestagios, $userdados);
                    // pr($userestagios);
                    // die('userestagios');
                    if ($this->Userestagios->save($userestagios)) {
                        $this->Flash->success(__('Usuário de estágio atualizado'));
                        return $this->redirect(['action' => 'view', $estudanteultimo_id->id]);
                    }
                    // die();
                }
                $this->Flash->success(__('Estudante cadastrado.'));
                return $this->redirect(['action' => 'view', $estudanteultimo_id->id]);
            }
            $estudanteultimo_id = $this->Estudantes->find()->orderDesc('id')->first();
            return $this->redirect(['action' => 'view', $estudanteultimo_id->id]);
            // $this->Flash->error(__('Não foi possível realizar o cadastro. Tente novamente.'));
        }

        $this->set(compact('estudante', 'registro', 'email'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $estudante = $this->Estudantes->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estudante);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudante = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Registo de estudante atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro de estudante no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('estudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $estudante = $this->Estudantes->get($id);
        $this->Authorization->authorize($estudante);

        if ($this->Estudantes->delete($estudante)) {
            $this->Flash->success(__('Registro de estudante excluído.'));
        } else {
            $this->Flash->error(__('Registro de estudante não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function planilhacress($id = NULL) {

        $this->Authorization->skipAuthorization();
        $periodo = !is_null($this->getRequest()->getQuery('periodo')) ? $this->getRequest()->getQuery('periodo') : NULL;
        // pr($periodo);
        // die();
        $ordem = 'Estudantes.nome';

        /* Todos os periódos */
        $periodototal = $this->Estudantes->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio então o período é o último período */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $cressquery = $this->Estudantes->Estagiarios->find()
                ->contain(['Estudantes', 'Instituicaoestagios', 'Supervisores', 'Docentes'])
                ->select(['Estagiarios.periodo', 'Estudantes.id', 'Estudantes.nome', 'Instituicaoestagios.id', 'Instituicaoestagios.instituicao', 'Instituicaoestagios.cep', 'Instituicaoestagios.endereco', 'Instituicaoestagios.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Docentes.nome'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->order(['Estudantes.nome']);

        $cress = $cressquery->all();
        // pr($cress);
        // die();
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    public function planilhaseguro($id = NULL) {

        $this->Authorization->skipAuthorization();
        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'nome';

        $periodototal = $this->Estudantes->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguroquery = $this->Estudantes->Estagiarios->find()
                ->contain(['Estudantes', 'Instituicaoestagios'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->select(['Estudantes.id', 'Estudantes.nome', 'Estudantes.cpf', 'Estudantes.nascimento', 'Estudantes.registro',
                    'Estagiarios.nivel', 'Estagiarios.periodo',
                    'Instituicaoestagios.instituicao'])
                ->order(['Estagiarios.nivel']);

        $seguro = $seguroquery->all();

        $i = 0;
        foreach ($seguro as $c_seguro) {
            // pr($c_seguro);
            // die();
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

                // Estagio não obrigatório. Conto como estágio 5
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

                // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';
            }

            $t_seguro[$i]['id'] = $c_seguro->estudante->id;
            $t_seguro[$i]['nome'] = $c_seguro->estudante->nome;
            $t_seguro[$i]['cpf'] = $c_seguro->estudante->cpf;
            $t_seguro[$i]['nascimento'] = $c_seguro->estudante->nascimento;
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro->estudante->registro;
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro->nivel == 9):
                // pr("Não");
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                // pr($c_seguro['Estagiario']['nivel']);
                $t_seguro[$i]['nivel'] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro->periodo;
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = $c_seguro->instituicaoestagio->instituicao;
            $criterio[$i] = $t_seguro[$i][$ordem];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

}
