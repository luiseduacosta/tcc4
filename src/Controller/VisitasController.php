<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Visitas Controller
 *
 * @property \App\Model\Table\VisitasTable $Visitas
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Visitas
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * 
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VisitasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->paginate = [
            'contain' => ['Instituicaoestagios'],
        ];
        $visitas = $this->paginate($this->Visitas);
        $this->Authorization->authorize($this->Visitas);
        $this->set(compact('visitas'));
    }

    /**
     * View method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $visita = $this->Visitas->get($id, [
            'contain' => ['Instituicaoestagios'],
        ]);
        $this->Authorization->authorize($visita);
        $this->set(compact('visita'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $visita = $this->Visitas->newEmptyEntity();
        $this->Authorization->authorize($visita);

        if ($this->request->is('post')) {
            $visita = $this->Visitas->patchEntity($visita, $this->request->getData());
            if ($this->Visitas->save($visita)) {
                $this->Flash->success(__('Visita inserida.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Visita não inserida.'));
        }
        $instituicaoestagios = $this->Visitas->Instituicaoestagios->find('list', ['limit' => 200]);
        $this->set(compact('visita', 'instituicaoestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $visita = $this->Visitas->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($visita);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $visita = $this->Visitas->patchEntity($visita, $this->request->getData());
            if ($this->Visitas->save($visita)) {
                $this->Flash->success(__('Visita atualizada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Visita não atualizada.'));
        }
        $instituicaoestagios = $this->Visitas->Instituicaoestagios->find('list', ['limit' => 200]);
        $this->set(compact('visita', 'instituicaoestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $visita = $this->Visitas->get($id);
        $this->Authorization->authorize($visita);

        if ($this->Visitas->delete($visita)) {
            $this->Flash->success(__('Visita excluída.'));
        } else {
            $this->Flash->error(__('Visita não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
