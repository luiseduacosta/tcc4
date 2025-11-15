<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Folhadeatividades Controller
 *
 * @property \App\Model\Table\FolhadeatividadesTable $Folhadeatividades
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Folhadeatividades
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Professores
 * 
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolhadeatividadesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id === null) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->select(['Estagiarios.nivel', 'Estagiarios.periodo', 'Alunos.nome', 'Supervisores.nome', 'Instituicoes.instituicao', 'Professores.nome'])
            ->first();

        $query = $this->Folhadeatividades->find()
            ->where(['Folhadeatividades.estagiario_id' => $estagiario_id])
            ->contain(['Estagiarios' => ['Alunos']])
            ->order(['Folhadeatividades.dia' => 'ASC']);

        if ($query) {
            if ($this->request->getQuery('sort') === null) {
                $query->order(['Folhadeatividades.dia' => 'ASC']);
            }
        } else {
            $this->Flash->error(__('Nenhum registro encontrado.'));
        }
        $folhadeatividades = $this->paginate($query);
        $this->set(compact('folhadeatividades', 'estagiario'));
    }

    /**
     * View method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == '1') {
            $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => ['Estagiarios' => ['Alunos']]
            ]);
        } elseif (isset($user) && $user->categoria == '2') {
            $estagiario = $this->Folhadeatividades->find()
                ->where(['Folhadeatividades.id' => $id])
                ->contain(['Alunos'])
                ->first();
            if ($estagiario) {
                /** Verifica se o estagiário é o mesmo do usuário */
                if ($user->estudante_id == $estagiario->aluno_id) {
                    $folhadeatividade = $this->Folhadeatividades->get($id, [
                        'contain' => ['Estagiarios' => ['Alunos']]
                    ]);
                } else {
                    $this->Flash->error(__('Você não tem permissão para acessar esta página'));
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $user->estudante_id]);
                }
            } else {
                $this->Flash->error(__('Estagiário não encontrado'));
                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
            }
        }
        $this->set(compact('folhadeatividade'));
    }

    /**
     * Atividade method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function atividade($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == '2') {
            if ($id) {
                $estagiario = $this->Folhadeatividades->find()
                    ->where(['Folhadeatividades.id' => $id])
                    ->contain(['Estagiarios' => ['Alunos']])
                    ->first();
                if ($estagiario) {
                    $estagiario_id = $estagiario->estagiario->id;
                    /** Verifica se o estagiário é o mesmo do usuário */
                    if ($user->estudante_id == $estagiario->estagiario->aluno_id) {
                        $folhadeatividade = $this->Folhadeatividades->Estagiarios->find()
                            ->where(['Estagiarios.id' => $estagiario_id])
                            ->contain(['Folhadeatividades', 'Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
                            ->first();
                    } else {
                        $this->Flash->error(__('Você não tem permissão para acessar esta página'));
                        return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $user->estudante_id]);
                    }
                } else {
                    $this->Flash->error(__('Estagiário não encontrado'));
                    return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
                }
            } else {
                $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
                if (empty($estagiario_id)) {
                    $this->Flash->error(__('Selecione o estagiário'));
                    return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
                } else {
                    $estagiario = $this->fetchTable('Estagiarios')->find()
                        ->where(['Estagiarios.id' => $estagiario_id])
                        ->contain(['Alunos'])
                        ->order(['Estagiarios.id' => 'ASC'])
                        ->first();
                    if ($estagiario) {
                        /** Verifica se o estagiário é o mesmo do usuário */
                        if ($user->estudante_id == $estagiario->aluno_id) {
                            $folhadeatividade = $this->Folhadeatividades->Estagiarios->find()
                                ->where(['Estagiarios.id' => $estagiario_id])
                                ->contain(['Folhadeatividades', 'Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
                                ->first();
                        } else {
                            $this->Flash->error(__('Você não tem permissão para acessar esta página'));
                            return $this->redirect(['controller' => 'Alunos', 'action' => 'atividade', '?' => ['estagiario_id' => $estagiario_id]]);
                        }
                    } else {
                        $this->Flash->error(__('Estagiário não encontrado'));
                        return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
                    }
                }
            }
        } elseif (isset($user) && $user->categoria == '1') {
            $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
            if (empty($estagiario_id)) {
                $this->Flash->error(__('Selecione o estagiário'));
                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
            } else {
                $folhadeatividade = $this->Folhadeatividades->Estagiarios->find()
                    ->where(['Estagiarios.id' => $estagiario_id])
                    ->contain(['Folhadeatividades', 'Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
                    ->first();
            }
        } else {
            $this->Flash->error(__('Você não tem permissão para acessar esta página'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $user->estudante_id]);
        }
        if ($folhadeatividade) {
            $this->set(compact('folhadeatividade'));
        } else {
            $this->Flash->error(__('Não há folha de atividades para este estagiário'));
            return $this->redirect(['controller' => 'Folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
        }
    }

    /**
     * Add method
     *
     * @param string|null $id Estagiário id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL)
    {
        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id === null) {
            $this->Flash->error(__('Selecione o estagiário'));
            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        } else {
            $estagiario = $this->fetchTable('Estagiarios')
                ->find()
                ->contain(['Alunos'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
            if (!$estagiario) {
                $this->Flash->error(__('Estagiário não encontrado'));
                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
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

                return $this->redirect(['controller' => 'Folhadeatividades', 'action' => 'atividade', '?' => ['estagiario_id' => $estagiario_id]]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        }

        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($folhadeatividade);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividade atualizada.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar. Tente outra vez.'));
        }
        $estagiario = $this->Folhadeatividades->find()
            ->where(['Folhadeatividades.id' => $id])
            ->contain(['Estagiarios' => ['Alunos']])
            ->select(['Estagiarios.id', 'Alunos.nome'])
            ->first();
        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->Authorization->skipAuthorization();
        try {
            $folhadeatividade = $this->Folhadeatividades->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($folhadeatividade);

        if ($this->request->is(['post', 'delete'])) {   
            if ($this->Folhadeatividades->delete($folhadeatividade)) {
                $this->Flash->success(__('Folha de atividade excluída.'));
            } else {
                $this->Flash->error(__('Folha de atividade não excluída.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    public function selecionafolhadeatividades($id = NULL)
    {

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
                ->contain(['Estudantes', 'Supervisores', 'instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('numero')]);
            $estagiario = $estagiarioquery->all();
            $this->set('estagiario', $estagiario);
        }
    }

    /**
     * Folhadeatividadespdf method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function folhadeatividadespdf($id = NULL)
    {
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $this->Authorization->skipAuthorization();
        $this->layout = false;
        if (is_null($estagiario_id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        } else {
            $folha = $this->Folhadeatividades->find()
                ->where(['Folhadeatividades.estagiario_id' => $estagiario_id])
                ->order(['Folhadeatividades.dia' => 'ASC'])
                ->all();

            $estagiario = $this->Folhadeatividades->Estagiarios->find()
                ->contain(['Folhadeatividades', 'Alunos', 'Professores', 'Instituicoes', 'Supervisores'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'folha_de_atividades_' . $estagiario->aluno->nome . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('folha', $folha);
        $this->set('estagiario', $estagiario);
    }

}
