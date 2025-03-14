<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areainstituicoes Controller
 *
 * @property \App\Model\Table\AreainstituicoesTable $Areainstituicoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreainstituicoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $areainstituicoes = $this->paginate($this->Areainstituicoes);
        $this->Authorization->authorize($this->Areainstituicoes);
        $this->set(compact('areainstituicoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($areainstituicao);
        $this->set(compact('areainstituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $areainstituicao = $this->Areainstituicoes->newEmptyEntity();
        $this->Authorization->authorize($areainstituicao);
        if ($this->request->is('post')) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('Área de instituição inserida.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Área de instituição não inserida.'));
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($areainstituicao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('Área de instituição atualizada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Área de instituição não atualizada.'));
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $areainstituicao = $this->Areainstituicoes->get($id);
        $this->Authorization->authorize($areainstituicao);
        if ($this->Areainstituicoes->delete($areainstituicao)) {
            $this->Flash->success(__('Área da instituição excluída.'));
        } else {
            $this->Flash->error(__('Área da instituição não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
