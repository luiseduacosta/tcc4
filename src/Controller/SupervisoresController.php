<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        $supervisores = $this->paginate($this->Supervisores);
        $this->Authorization->authorize($this->Supervisores);
        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        if (is_null($id)):
            $cress = $this->getRequest()->getQuery('cress');
            $supervisorquery = $this->Supervisores->find()
                    ->where(['cress' => $cress]);
            $supervisor = $supervisorquery->first();
            $id = $supervisor->id;
        endif;

        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicaoestagios' => ['Areainstituicoes'], 'Estagiarios' => ['Estudantes', 'Supervisores', 'Professores', 'Instituicaoestagios']],
        ]);
        $this->Authorization->authorize($supervisor);
        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $supervisor = $this->Supervisores->newEmptyEntity();
        $this->Authorization->authorize($supervisor);

        if ($this->request->is('post')) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Registro de supervisora realizado.'));
                $ultimo_id = $this->Supervisores->find()->orderDesc('id')->first();
                return $this->redirect(['action' => 'view', $ultimo_id->id]);
            }
            $this->Flash->error(__('O registro da supervisora não foi realizado. Tente novamente.'));
        }
        $instituicaoestagios = $this->Supervisores->Instituicaoestagios->find('list');
        $this->set(compact('supervisor', 'instituicaoestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicaoestagios'],
        ]);
        $this->Authorization->authorize($supervisor);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Supervisora atualizada .'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('A supervisora não foi atualizada. Tente novamente.'));
        }
        $instituicaoestagios = $this->Supervisores->Instituicaoestagios->find('list');
        $this->set(compact('supervisor', 'instituicaoestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $supervisor = $this->Supervisores->get($id);
        $this->Authorization->authorize($supervisor);

        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('The supervisor has been deleted.'));
        } else {
            $this->Flash->error(__('The supervisor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
