<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicaoestagios Controller
 *
 * @property \App\Model\Table\InstituicaoestagiosTable $Instituicaoestagios
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicaoestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        $this->paginate = [
            'contain' => ['Supervisores', 'Areainstituicoes', 'Areaestagios'],
        ];
        $instituicaoestagios = $this->paginate($this->Instituicaoestagios);
        $this->Authorization->authorize($this->Instituicaoestagios);

        $this->set(compact('instituicaoestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $instituicaoestagio = $this->Instituicaoestagios->get($id, [
            'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Alunos', 'Estudantes', 'Instituicaoestagios', 'Docentes', 'Supervisores', 'Areaestagios'], 'Muralestagios', 'Visitas'],
        ]);
        $this->Authorization->authorize($instituicaoestagio);
        $this->set(compact('instituicaoestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $instituicaoestagio = $this->Instituicaoestagios->newEmptyEntity();
        $this->Authorization->authorize($instituicaoestagio);

        if ($this->request->is('post')) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('Instituição de estagio creada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível criar a  instituição de estágio. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list', ['limit' => 200]);
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $instituicaoestagio = $this->Instituicaoestagios->get($id, [
            'contain' => ['Supervisores'],
        ]);
        $this->Authorization->authorize($instituicaoestagio);        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('The instituicaoestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The instituicaoestagio could not be saved. Please, try again.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list', ['limit' => 200]);
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list', ['limit' => 200]);
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $instituicaoestagio = $this->Instituicaoestagios->get($id);
        $this->Authorization->authorize($instituicaoestagio);        
        if ($this->Instituicaoestagios->delete($instituicaoestagio)) {
            $this->Flash->success(__('The instituicaoestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The instituicaoestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
