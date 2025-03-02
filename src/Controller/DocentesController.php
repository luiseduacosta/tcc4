<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Docentes Controller
 *
 * @property \App\Model\Table\DocentesTable $Docentes
 *
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocentesController extends AppController {

    public $Docentes = null;
    
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        
        parent::beforeFilter($event);
        
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index0 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $this->Authorization->skipAuthorization();
        $docentes = $this->paginate($this->Docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index0() {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index1 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index1() {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index2 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index2() {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index3 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index3() {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * View method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $docente = $this->Docentes->get($id, [
            'contain' => ['Monografias', 'Areamonografias'],
        ]);
        $this->set('docente', $docente);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $docente = $this->Docentes->newEmptyEntity();
        $this->Authorization->authorize($docente);
        if ($this->request->is('post')) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('The docente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The docente could not be saved. Please, try again.'));
        }
        $this->set(compact('docente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $docente = $this->Docentes->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($docente);
        pr($this->request->getData());
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('The docente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The docente could not be saved. Please, try again.'));
        }
        $this->set(compact('docente'));
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
        $docente = $this->Docentes->get($id);
        $this->Authorization->authorize($docente);

        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('The docente has been deleted.'));
        } else {
            $this->Flash->error(__('The docente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
