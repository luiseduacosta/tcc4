<?php

declare(strict_types=1);
namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Supervisores
 * @property \Cake\ORM\TableRegistry $Instituicoes
 * @property \Cake\ORM\TableRegistry $Estagiarios
 * @property \Cake\ORM\TableRegistry $Alunos
 * @property \Cake\ORM\TableRegistry $Professores
 * 
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Supervisores->find();
        if (!$query->toArray()) {
            $this->Flash->error(__('Nenhum supervisor encontrado.'));
            return $this->redirect(['action' => 'add']);
        }
        if ($this->request->getQuery('sort') === null) {
            $query->order(['nome' => 'ASC']);
        }
        $supervisores = $this->paginate($query, [
            'sortableFields' => ['nome', 'cress']
        ]);
        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @param string|null $cress Supervisor cress.
     * 
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $cress = null)
    {
        $this->Authorization->skipAuthorization();
        if ($id === null):
            $cress = $this->getRequest()->getQuery('cress');
            if (!$cress) {
                $this->Authorization->skipAuthorization();
                $this->Flash->error(__('Cress inválido.'));
                return $this->redirect(['action' => 'index']);
            }
            $supervisor = $this->Supervisores->find()
                ->where(['cress' => $cress])
                ->first();
            if (!$supervisor) {
                $this->Authorization->skipAuthorization();
                $this->Flash->error(__('Supervisora não encontrada.'));
                return $this->redirect(['action' => 'index']);
            }
            $id = $supervisor->id;
        endif;
        try {
            $this->Authorization->skipAuthorization();
            $supervisor = $this->Supervisores->get($id, [
                'contain' => ['Instituicoes' => ['Areainstituicoes'], 'Estagiarios' => ['Alunos', 'Supervisores', 'Professores', 'Instituicoes']],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supervisor = $this->Supervisores->newEmptyEntity();
        $this->Authorization->authorize($supervisor);

        if ($this->request->is('post')) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Registro de supervisora realizado.'));
                return $this->redirect(['action' => 'view', $supervisor->id]);
            }
            $this->Flash->error(__('O registro da supervisora não foi realizado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            $supervisor = $this->Supervisores->get($id, [
                'contain' => ['Instituicoes'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($supervisor);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Supervisora atualizada com sucesso.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('A supervisora não foi atualizada. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->Authorization->skipAuthorization();
            $supervisor = $this->Supervisores->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($supervisor);

        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('Registro de supervisora excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Registro de supervisora não excluído. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Busca supervisor por nome
     *
     * @param string|null $nome Nome do supervisor.
     * @return \Cake\Http\Response|null|void
     */
    public function buscasupervisor($nome = null)
    {
        $this->Authorization->skipAuthorization();
        $nome = trim($this->request->getData("nome"));
        if ($nome) {
            $supervisores = $this->Supervisores->find("all", [
                "conditions" => ["Supervisores.nome LIKE" => "%$nome%"],
                "order" => ["Supervisores.nome" => "asc"]
            ]);
            if ($supervisores->toArray()) {
                $this->Flash->success(__("Supervisores encontrados com o nome '$nome'."));
                $this->set("supervisores", $this->paginate($supervisores));
                $this->render("index");
            } else {
                $this->Flash->error(__("Nenhum supervisor encontrado com o nome '$nome'."));
                return $this->redirect([
                    "controller" => "Supervisores",
                    "action" => "index"
                ]);
            }
        } else {
            $this->Flash->error(__("Digite um nome para buscar"));
            return $this->redirect([
                "controller" => "Supervisores",
                "action" => "index"
            ]);
        }
    }

}
