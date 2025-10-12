<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Instituicoes Controller
 *
 * @property \App\Model\Table\InstituicoesTable $Instituicoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Areainstituicoes
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Muralestagios
 * @property \Cake\ORM\TableRegistry $Visitas
 * 
 * @method \App\Model\Entity\Instituicoes[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicoesController extends AppController
{

    /**
     * Index method
     * 
     * @param string|null $instituicao
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($instituicao = null)
    {
        $instituicao = $this->getRequest()->getData('nome');
        if ($instituicao) {
            $query = $this->Instituicoes->find('all');
            $query->where(['Instituicoes.instituicao LIKE' => "%{$instituicao}%"]);
            $query->contain(['Areainstituicoes']);
            $query->order(['Instituicoes.instituicao' => 'ASC']);
        } else {
            $query = $this->Instituicoes->find('all', [
                'contain' => ['Areainstituicoes'],
                'order' => ['Instituicoes.instituicao' => 'ASC']
            ]);
        }
        if (!$query->toArray()) {
            $this->Authorization->skipAuthorization();
            $this->Flash->error(__('Instituição: ' . $instituicao . ' não encontrada. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->Authorization->skipAuthorization()) {
            $instituicoes = $this->paginate($query);
        } else {
            $this->Flash->error(__('Acesso não autorizado.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('instituicoes'));
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
        $this->Authorization->skipAuthorization();
        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores', 'Turmaestagios'], 'Muralestagios', 'Visitas']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('instituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $instituicao = $this->Instituicoes->newEmptyEntity();
        $this->Authorization->authorize($instituicao);

        if ($this->request->is('post')) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Instituição de estágio criada.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Não foi possível criar a  instituição de estágio. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicao', 'areainstituicoes', 'supervisores'));
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

        $this->Authorization->skipAuthorization();
        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Supervisores'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            $this->Authorization->authorize($instituicao);
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Instituição de estágio atualizada.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Instituição de estágio não foi atualizada.'));
            return $this->redirect(['action' => 'index']);
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicao', 'areainstituicoes', 'supervisores'));
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
        try {
            $this->Authorization->skipAuthorization();
            $instituicao = $this->Instituicoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $this->Authorization->authorize($instituicao);
        if ($this->Instituicoes->delete($instituicao)) {
            $this->Flash->success(__('Instituição de estágio excluída.'));
        } else {
            $this->Flash->error(__('Instituição de estágio não foi excluída.'));
            return $this->redirect(['action' => 'view', $instituicao->id]);
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * buscasupervisores method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function buscasupervisores()
    {

        $this->Authorization->skipAuthorization();
        if (!$this->request->is('post')) {
            return $this->response->withStatus(400);
        }

        $instituicao_id = $this->request->getData('id');
        try {
            $supervisores = $this->Instituicoes->Supervisores->find(
                'list',
                [
                    'keyField' => 'id',
                    'valueField' => 'nome',
                    'joinTable' => 'inst_super',
                    'joinType' => 'INNER'
                ]
            )
                ->matching('Instituicoes', function ($q) use ($instituicao_id) {
                    return $q->where(['Instituicoes.id' => $instituicao_id]);
                })
                ->order(['nome' => 'ASC'])
                ->toArray();

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($supervisores));

        } catch (\Exception $e) {
            return $this->response
                ->withStatus(500)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Erro ao buscar supervisores']));
        }

    }

    /**
     * buscainstituicao method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function buscainstituicao()
    {
        $this->Authorization->skipAuthorization();
        $instituicao = $this->getRequest()->getData('instituicao');
        if ($instituicao) {
            return $this->redirect([
                "controller" => "Instituicoes",
                "action" => "index",
                "?" => ["instituicao" => $instituicao]
            ]);
        } else {
            $this->Flash->error(__('Digite um nome para busca'));
            return $this->redirect([
                "controller" => "Instituicoes",
                "action" => "index"
            ]);
        }
    }   
}
