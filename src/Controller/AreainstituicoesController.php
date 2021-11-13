<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areainstituicoes Controller
 *
 * @property \App\Model\Table\AreainstituicoesTable $Areainstituicoes
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
        $this->Authorization->skipAuthorization();
        $areainstituicoes = $this->paginate($this->Areainstituicoes);

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
        $this->Authorization->skipAuthorization();
        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('areainstituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $areainstituicao = $this->Areainstituicoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('The areainstituicao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The areainstituicao could not be saved. Please, try again.'));
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
        $this->Authorization->skipAuthorization();
        $areainstituicao = $this->Areainstituicoes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('The areainstituicao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The areainstituicao could not be saved. Please, try again.'));
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
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'delete']);
        $areainstituicao = $this->Areainstituicoes->get($id);
        if ($this->Areainstituicoes->delete($areainstituicao)) {
            $this->Flash->success(__('The areainstituicao has been deleted.'));
        } else {
            $this->Flash->error(__('The areainstituicao could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
