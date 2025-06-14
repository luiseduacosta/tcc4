<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Rule\IsUnique;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Professores
 * @property \Cake\ORM\TableRegistry $Turmaestagios
 *
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
/**
 * EstagiariosController handles actions related to the management of interns (estagiarios).
 * It provides functionalities for viewing, adding, editing, and deleting interns,
 * as well as generating various PDF documents related to intern evaluations and activities.
 * The controller also manages the filtering and pagination of intern records based on certain criteria.
 */
class EstagiariosController extends AppController
{

    /**
     * initialize method
     *
     * @return void
     */
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

        $instituicao = $this->getRequest()->getQuery('instituicao');
        $supervisor = $this->getRequest()->getQuery('supervisor');
        $professor = $this->getRequest()->getQuery('professor');
        $turmaestagio = $this->getRequest()->getQuery('turmaestagio');
        $nivel = $this->getRequest()->getQuery('nivel');
        $periodo = $this->getRequest()->getQuery('periodo');
        if ($periodo === null) {
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
        if ($nivel) {
            $query->where(['Estagiarios.nivel' => $nivel, 'Estagiarios.periodo' => $periodo]);
        }
        if ($instituicao) {
            $query->where(['Instituicoes.id' => $instituicao, 'Estagiarios.periodo' => $periodo]);
        }
        if ($supervisor) {
            $query->where(['Supervisores.id' => $supervisor, 'Estagiarios.periodo' => $periodo]);
        }
        if ($professor) {
            $query->where(['Professores.id' => $professor, 'Estagiarios.periodo' => $periodo]);
        }
        if ($turmaestagio) {
            $query->where(['Turmaestagios.id' => $turmaestagio, 'Estagiarios.periodo' => $periodo]);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome', 'nota', 'ch']];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => ['periodo' => 'asc']
        ]);
        $periodos = $periodototal->toArray();

        $instituicoes = $this->Estagiarios->find('all', [
            'contain' => ['Instituicoes', 'Supervisores', 'Professores', 'Turmaestagios'],
            'order' => ['Instituicoes.instituicao' => 'asc'],
            'conditions' => ['Estagiarios.periodo' => $periodo],
            'group' => ['Instituicoes.id']
        ]);
        $instituicoes = $instituicoes->toArray();

        $listainstituicoes = [];
        $listasupervisores = [];
        $listaprofessores = [];
        $listaturmaestagios = [];

        foreach ($instituicoes as $instituicao) {
            if (!empty($instituicao->instituicao->id)) {
                $listainstituicoes[$instituicao->instituicao->id] = $instituicao->instituicao->instituicao;
                asort($listainstituicoes);
            }
        }
        foreach ($instituicoes as $supervisor) {
            if (!empty($supervisor->supervisor->id)) {
                $listasupervisores[$supervisor->supervisor->id] = $supervisor->supervisor->nome;
                asort($listasupervisores);
            }
        }
        foreach ($instituicoes as $professor) {
            if (!empty($professor->professor->id)) {
                $listaprofessores[$professor->professor->id] = $professor->professor->nome;
                asort($listaprofessores);
            }
        }
        foreach ($instituicoes as $turmaestagio) {
            if (!empty($turmaestagio->turmaestagio->id)) {
                $listaturmaestagios[$turmaestagio->turmaestagio->id] = $turmaestagio->turmaestagio->area;
                asort($listaturmaestagios);
            }
        }

        if (!empty($listainstituicoes)) {
            $this->set('instituicoes', $listainstituicoes);
        }
        if (!empty($listasupervisores)) {
            $this->set('supervisores', $listasupervisores);
        }
        if (!empty($listaprofessores)) {
            $this->set('professores', $listaprofessores);
        }
        if (!empty($listaturmaestagios)) {
            $this->set('turmaestagios', $listaturmaestagios);
        }

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

        /** Corrigir para autorizar ao $estagiario */
        $this->Authorization->skipAuthorization();

        $estagiario = $this->Estagiarios->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
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
     * novotermocompromisso method
     * @param string|null $aluno_id ID do aluno
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function novotermocompromisso($id = NULL)
    {
        $this->viewBuilder()->enableAutoLayout(false);
        $this->Authorization->skipAuthorization();

        $aluno_id = $this->getRequest()->getQuery('aluno_id');
        if (empty($aluno_id)) {
            $user = $this->getRequest()->getAttribute('identity');
            if (isset($user) && $user->categoria == '2') {
                $aluno_id = $user->estudante_id;
            }
        }
        if ($aluno_id === null) {
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
        if ($id === null) {
            throw new \Cake\Http\Exception\NotFoundException(__('Sem parâmetros para localizar o estagiário'));
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $id]);
        }
        $configuracao = $this->fetchTable('Configuracao')->find()->where(['Configuracao.id' => 1])->first();

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

        if ($estagiario === null) {
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

        if ($estagiario->supervisor->id === null) {
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

    /**
     * folhadeatividadespdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
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

        if ($estagiario === null) {
            $this->Flash->error(__('Sem estagiario cadastrado'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'index']);
        } else {
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
    }

    /**
     * selecionaavaliacaodiscente method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
    public function selecionaavaliacaodiscente($id = NULL)
    {
        $estagiario_id = $this->getRequest()->getQuery(
            'estagiario_id'
        );
        $this->Authorization->skipAuthorization();
        /* No login foi capturado o id do estagiário */
        if (empty($estagiario_id)) {
            $user = $this->getRequest()->getAttribute('identity');
            if (isset($user) && $user->categoria == '2') {
                $estagiario = $this->Estagiarios->find()
                    ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.aluno_id' => $user->estudante_id]);
                $estagiario = $estagiario->first();
            } else {
                $this->Flash->error(__('Selecionar o estudante estagiário'));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $estagiario_id]);
            $estagiario = $estagiario->first();
        }

        $this->set('estagiario', $estagiario);
    }

    /**
     * avaliacaodiscentepdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
    public function avaliacaodiscentepdf($id = NULL)
    {

        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->disableAutoLayout();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        if ($estagiario_id) {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores', 'Avaliacoes'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        } else {
            $this->Flash->error(__('Sem estagiarios cadastrados'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $estagiario_id]);
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
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->skipAuthorization();
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estagiario);
        if ($estagiario === null) {
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
        $supervisores = [];
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
        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($estagiario);
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == '1') {
            if ($this->Estagiarios->delete($estagiario)) {
                $this->Flash->success(__('Estagiário excluído.'));
                return $this->redirect(['action'=> 'index']);
            } else {
                $this->Flash->error(__('Não foi possível excluir o estagiário'));
            }
        } else {
            $this->Flash->error(__('Apenas administradores podem excluir estagiários'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * lancanota method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view otherwise.
     */
    public function lancanota($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == '3') {
            $siape = $user->numero;
        } elseif (isset($user) && $user->categoria == '1') {
            $siape = $this->getRequest()->getQuery('siape');
        }
        if ($siape === null) {
            $this->Flash->error(__('Sem parâmetro para localizar o estagiário do(a) professor(a).'));
            return $this->redirect(['action' => 'index']);
        }
        $estagiarios = $this->Estagiarios->Professores->find()
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
                ->where(['Professores.siape' => $siape])
                ->first();

        $this->Authorization->skipAuthorization();

        $i = 0;
        $estagiarioslancanota[] = null;
        $estagiarios = $estagiarios->estagiarios;
        foreach ($estagiarios as $estagiario):
            foreach ($estagiario as $c_estagio):
                $estagiarioslancanota[$i]['id'] = $c_estagio['id'];
                $estagiarioslancanota[$i]['registro'] = $c_estagio['registro'];
                $estagiarioslancanota[$i]['periodo'] = $c_estagio['periodo'];
                $estagiarioslancanota[$i]['nivel'] = $c_estagio['nivel'];
                $estagiarioslancanota[$i]['nota'] = $c_estagio['nota'];
                $estagiarioslancanota[$i]['ch'] = $c_estagio['ch'];
                $estagiarioslancanota[$i]['instituicao_id'] = $c_estagio['instituicao']['id'];
                $estagiarioslancanota[$i]['instituicao'] = $c_estagio['instituicao']['instituicao'];
                $estagiarioslancanota[$i]['supervisor_id'] = $c_estagio['supervisor']['id'];
                $estagiarioslancanota[$i]['supervisora'] = $c_estagio['supervisor']['nome'];
                $estagiarioslancanota[$i]['professor_id'] = $c_estagio['docente']['id'];
                $estagiarioslancanota[$i]['docente'] = $c_estagio['docente']['nome'];
                $estagiarioslancanota[$i]['estudante_id'] = $c_estagio['aluno']['id'];
                $estagiarioslancanota[$i]['estudante'] = $c_estagio['aluno']['nome'];
                if (isset($c_estagio['avaliacao']['id'])):
                    $estagiarioslancanota[$i]['avaliacao_id'] = $c_estagio['avaliacao']['id'];
                else:
                    $estagiarioslancanota[$i]['avaliacao_id'] = null;
                endif;
                $i++;
            endforeach;

        endforeach;
        $this->set('estagiarios', $estagiarioslancanota);
    }
}
