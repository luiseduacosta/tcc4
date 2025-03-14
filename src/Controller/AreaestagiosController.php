<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Areaestagios Controller
 *
 * @property \App\Model\Table\AreaestagiosTable $Areaestagios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreaestagiosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $areaestagios = $this->paginate($this->Areaestagios);
        $this->Authorization->authorize($this->Areaestagios);

        $this->set(compact('areaestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $areaestagio = $this->Areaestagios->get($id, [
            'contain' => ['Estagiarios' => ['Alunos', 'Estudantes', 'Instituicaoestagios', 'Supervisores', 'Professores', 'Areaestagios'], 'Muralestagios'],
        ]);
        $this->Authorization->authorize($areaestagio);
        $this->set(compact('areaestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $areaestagio = $this->Areaestagios->newEmptyEntity();
        $this->Authorization->authorize($areaestagio);
        if ($this->request->is('post')) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('Área de estágio inserida.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Área de estágio não inserida.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $areaestagio = $this->Areaestagios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($areaestagio);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('Área de estagio atualizada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Área de estagio não atualizada.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $areaestagio = $this->Areaestagios->get($id);
        $this->Authorization->authorize($areaestagio);
        if ($this->Areaestagios->delete($areaestagio)) {
            $this->Flash->success(__('Área de estagio excluída.'));
        } else {
            $this->Flash->error(__('Área de estagio não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
