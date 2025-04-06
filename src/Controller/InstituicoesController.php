<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicoes Controller
 *
 * @property \App\Model\Table\InstituicoesTable $Instituicoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Instituicoes[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicoesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $query = $this->Instituicoes->find('all', [
            'contain' => ['Supervisores', 'Areainstituicoes'],
            'order' => ['instituicao' => 'ASC']
        ]);
        $instituicaoestagios = $this->paginate( $query);
        $this->Authorization->skipAuthorization();

        $this->set(compact('instituicaoestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $instituicaoestagio = $this->Instituicoes->get($id, [
            'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores'], 'Muralestagios', 'Visitas'],
        ]);
        $this->Authorization->authorize($instituicaoestagio);
        $this->set(compact('instituicaoestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $instituicaoestagio = $this->Instituicoes->newEmptyEntity();
        $this->Authorization->authorize($instituicaoestagio);

        if ($this->request->is('post')) {
            $instituicaoestagio = $this->Instituicoes->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicoes->save($instituicaoestagio)) {
                $this->Flash->success(__('Instituição de estagio creada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível criar a  instituição de estágio. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicoes id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $instituicaoestagio = $this->Instituicoes->get($id, [
            'contain' => ['Supervisores'],
        ]);
        $this->Authorization->authorize($instituicaoestagio);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicaoestagio = $this->Instituicoes->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicoes->save($instituicaoestagio)) {
                $this->Flash->success(__('Instituição de estágio atualizada.'));

                return $this->redirect(['action' => 'view', $instituicaoestagio->id]);
            }
            $this->Flash->error(__('Instituição de estágio não foia atualizada.'));
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $instituicaoestagio = $this->Instituicoes->get($id);
        $this->Authorization->authorize($instituicaoestagio);
        if ($this->Instituicoes->delete($instituicaoestagio)) {
            $this->Flash->success(__('Instituição de estágio excluída.'));
        } else {
            $this->Flash->error(__('Instituição de estágio não foi excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
