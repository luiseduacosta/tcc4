<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Docentes Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Docentes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocentesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index0 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $this->Authorization->skipAuthorization();
        $docentes = $this->paginate($this->Docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index0()
    {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($Docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index1 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index1()
    {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index2 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index2()
    {

        $docentes = $this->paginate($this->Docentes);
        // $this->Authorization->authorize($docentes);
        $this->set(compact('docentes'));
    }

    /**
     * Index3 method
     *
     * @return \Cake\Http\Response|null
     */
    public function index3()
    {

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
    public function view($id = null)
    {

        $docentetable = $this->fetchTable("Docentes");
        $this->Authorization->skipAuthorization();
        $docente = $docentetable->get($id, [
            'contain' => ['Monografias', 'Areamonografias'],
        ]);
        $this->set('docente', $docente);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $docentetable = $this->fetchTable("Docentes");
        $docente = $docentetable->newEmptyEntity();
        $this->Authorization->authorize($docente);

        if ($this->request->is('post')) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro docente inserido'));
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
    public function edit($id = null)
    {

        $docentetable = $this->fetchTable("Docentes");
        $docente = $docentetable->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($docente);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro docente não atualizado.'));
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
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $docente = $this->Docentes->get($id);
        $this->Authorization->authorize($docente);

        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('Registro docente excluído.'));
        } else {
            $this->Flash->error(__('Registro docente não excluídio'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
