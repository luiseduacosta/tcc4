<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Docentemongrafias Controller
 *
 * @property \App\Model\Table\DocentemonografiasTable $Docentemonografias
 *
 * @method \App\Model\Entity\Docentemonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocentemonografiasController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        if ($this->getRequest()->getAttribute('identity')['categoria'] == '1') {
            $this->Authorization->skipAuthorization();
        }
        // $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index0 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $docentemonografias = $this->paginate($this->Docentemonografias);
        $this->Authorization->authorize($this->Docentemonografias);
        $this->set(compact('docentemonografias'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index0() {

        $docentemonografias = $this->paginate($this->Docentemonografias);
        $this->Authorization->authorize($this->Docentemonografias);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentemonografias'));
    }

    /**
     * Index1 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index1() {

        $docentemonografias = $this->paginate($this->Docentemonografias);
        $this->Authorization->authorize($this->Docentemonografias);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentemonografias'));
    }

    /**
     * Index2 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index2() {

        $docentemonografias = $this->paginate($this->Docentemonografias);
        $this->Authorization->authorize($this->Docentemonografias);
        $this->set(compact('docentemonografias'));
    }

    /**
     * Index3 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index3() {

        $docentemonografias = $this->paginate($this->Docentemonografias);
        $this->Authorization->authorize($this->Docentemonografias);
        $this->set(compact('docentemonografias'));
    }

    /**
     * View method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $docentemonografia = $this->Docentemonografias->get($id, [
            'contain' => ['Monografias', 'Areamonografias'],
        ]);
        $this->Authorization->authorize($docentemonografia);
        $this->set('docentemonografia', $docentemonografia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $docentemonografia = $this->Docentemonografias->newEmptyEntity();
        $this->Authorization->authorize($docentemonografia);
        if ($this->request->is('post')) {
            $docentemonografia = $this->Docentemonografias->patchEntity($docentemonografia, $this->request->getData());
            if ($this->Docentemonografias->save($docentemonografia)) {
                $this->Flash->success(__('Docente registrado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro de docente não realizado. Tente novamente.'));
        }
        $this->set(compact('docentemonografia'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $docentemonografia = $this->Docentemonografias->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($docentemonografia);
        // pr($this->request->getData());
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentemonografias->patchEntity($docentemonografia, $this->request->getData());
            if ($this->Docentemonografias->save($docentemonografia)) {
                $this->Flash->success(__('Registro docente atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro docente não foi atualizado. Tente novamente.'));
        }
        $this->set(compact('docentemonografia'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $docentemonografia = $this->Docentemonografias->get($id);
        $this->Authorization->authorize($docentemonografia);

        if ($this->Docentemonografias->delete($docentemonografia)) {
            $this->Flash->success(__('Registro docente excluído.'));
        } else {
            $this->Flash->error(__('O registro do docente não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
