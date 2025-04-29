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
            'order' => ['Instituicoes.instituicao' => 'ASC']
        ]);
        $instituicoes = $this->paginate($query);
        $this->Authorization->skipAuthorization();

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

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível criar a  instituição de estágio. Tente novamente.'));
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

        $instituicao = $this->Instituicoes->get($id, [
            'contain' => ['Supervisores'],
        ]);
        $this->Authorization->authorize($instituicao);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Instituição de estágio atualizada.'));

                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Instituição de estágio não foi atualizada.'));
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

        $this->request->allowMethod(['post', 'delete']);
        $instituicao = $this->Instituicoes->get($id);
        $this->Authorization->authorize($instituicao);
        if ($this->Instituicoes->delete($instituicao)) {
            $this->Flash->success(__('Instituição de estágio excluída.'));
        } else {
            $this->Flash->error(__('Instituição de estágio não foi excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function buscasupervisores()
    {

        $this->Authorization->skipAuthorization();

        if (!$this->request->is('post')) {
            return $this->response->withStatus(400);
        }

        $instituicao_id = $this->request->getData('id');

        // $instituicao_id = 265; // Exemplo de ID da instituição, você pode substituir isso por um valor dinâmico

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

}
