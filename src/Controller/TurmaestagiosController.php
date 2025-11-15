<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Turmaestagios Controller
 *
 * @property \App\Model\Table\TurmaestagiosTable $Turmaestagios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Turmaestagios
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Professores
 * 
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TurmaestagiosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $turmaestagios = $this->paginate($this->Turmaestagios);

        $this->set(compact('turmaestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            ini_set('memory_limit', '2048M');
            $turmaestagio = $this->Turmaestagios->get($id, [
                'contain' => ['Estagiarios' => ['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de turmas de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('turmaestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $turmaestagio = $this->Turmaestagios->newEmptyEntity();
        $this->Authorization->authorize($turmaestagio);
        if ($this->request->is('post')) {
            $turmaestagio = $this->Turmaestagios->patchEntity($turmaestagio, $this->request->getData());
            if ($this->Turmaestagios->save($turmaestagio)) {
                $this->Flash->success(__('Turma de estagio inserida.'));
                return $this->redirect(['action' => 'view', $turmaestagio->id]);
            }
            $this->Flash->error(__('Não foi possível inserir a Turma de estagio. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('turmaestagio'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            $turmaestagio = $this->Turmaestagios->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de turmas de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($turmaestagio);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $turmaestagio = $this->Turmaestagios->patchEntity($turmaestagio, $this->request->getData());
            if ($this->Turmaestagios->save($turmaestagio)) {
                $this->Flash->success(__('Turma de estagio atualizada com sucesso.'));
                return $this->redirect(['action' => 'view', $turmaestagio->id]);
            }
            $this->Flash->error(__('Turma de estágio não foi atualizada. Tente novamente.'));
            return $this->redirect(['action' => 'view', $turmaestagio->id]);
        }
        $this->set(compact('turmaestagio'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            $turmaestagio = $this->Turmaestagios->get($id, [
                'contain' => ['Estagiarios']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de turmas de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($turmaestagio);
        if (sizeof($turmaestagio->estagiarios) > 0) {
            $this->Flash->error(__("Não pode ser excluida porque têm estagiários associados."));
            return $this->redirect(['controller' => 'Turmaestagios', 'action' => 'view', $id]);
        }
        if ($this->request->is(['post', 'delete'])) {
            if ($this->Turmaestagios->delete($turmaestagio)) {
                $this->Flash->success(__('Turma de estágio excluída.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Turma de estágio não foi excluída. Tente novamente.'));
                return $this->redirect(['action' => 'view', $turmaestagio->id]);
            }
        }
    }
}
