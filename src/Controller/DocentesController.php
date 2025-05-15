<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Docentes Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Docentes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Docentes
 * @property \Cake\ORM\TableRegistry $Monografias
 * @property \Cake\ORM\TableRegistry $Areamonografias
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
     * Index method
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
     * View method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        if (empty($id)) {
            $this->Flash->error(__('Registro ID do docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }
        $docente = $this->fetchTable("Docentes")
            ->get(
                $id,
                [
                    'contain' => ['Monografias', 'Areamonografias'],
                ]
            );
        if (empty($docente)) {
            $this->Flash->error(__('Registro docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set('docente', $docente);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $docente = $this->fetchTable("Docentes")->newEmptyEntity();
        $this->Authorization->authorize($docente);

        if ($this->request->is('post')) {
            $siape = $this->request->getData('siape');
            $docentesiape = $this->Docentes->find()
                ->where(['siape' => $siape])
                ->first();
            if ($docentesiape):
                $this->Flash->error(__('Siape do docente já cadastrado'));
                return $this->redirect(['action' => 'view', $docentesiape->id]);
            endif;
            $email = $this->request->getData('email');
            $docenteemail = $this->Docentes->find()
                ->where(['email' => $email])
                ->first();
            if ($docenteemail):
                $this->Flash->error(__('E-mail do docente já cadastrado'));
                return $this->redirect(['action' => 'view', $docenteemail->id]);
            endif;
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente inserido.'));

                return $this->redirect(['action' => 'view', $docente->id]);
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

        $docente = $this->fetchTable("Docentes")->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($docente);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente atualizado.'));

                return $this->redirect(['action' => 'view', $docente->id]);
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

        if ($docente === null):
            $this->Flash->error(__('Registro docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        endif;

        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('Registro docente excluído.'));
        } else {
            $this->Flash->error(__('Registro docente não excluídio'));
        }

        return $this->redirect(['action' => 'index']);
    }

}