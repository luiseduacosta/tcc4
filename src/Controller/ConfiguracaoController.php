<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Configuracao Controller
 *
 * @property \App\Model\Table\ConfiguracaoTable $Configuracao
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Configuracao
 * 
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConfiguracaoController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $configuracao = $this->paginate($this->Configuracao);
        $this->Authorization->authorize($this->Configuracao);
        $this->set(compact('configuracao'));
    }

    /**
     * View method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $configuracao = $this->Configuracao->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($configuracao);
        $this->set(compact('configuracao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $configuracao = $this->Configuracao->newEmptyEntity();
        $this->Authorization->authorize($configuracao);
        if ($this->request->is('post')) {
            $configuracao = $this->Configuracao->patchEntity($configuracao, $this->request->getData());
            if ($this->Configuracao->save($configuracao)) {
                $this->Flash->success(__('Configuração inserida.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Configuração não inserida.'));
        }
        $this->set(compact('configuracao'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $configuracao = $this->Configuracao->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($configuracao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $configuracao = $this->Configuracao->patchEntity($configuracao, $this->request->getData());
            if ($this->Configuracao->save($configuracao)) {
                $this->Flash->success(__('Configuração atualizada.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar a configuração. Tente novamente.'));
        }
        $this->set(compact('configuracao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $configuracao = $this->Configuracao->get($id);
        $this->Authorization->authorize($configuracao);
        if ($this->Configuracao->delete($configuracao)) {
            $this->Flash->success(__('Configuração excluída.'));
        } else {
            $this->Flash->error(__('Configuração não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
