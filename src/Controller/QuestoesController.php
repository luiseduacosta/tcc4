<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Questoes Controller
 *
 * @property \App\Model\Table\QuestoesTable $Questoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestoesController extends AppController
{
    public array $paginate = [
        "sortableFields" => [
            "id",
            "type",
            "text",
            "options",
            "ordem",
            "questionario.title",
        ],
        "order" => ["ordem" => "ASC"],
        "limit" => 20,
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Questoes->find()->contain(["Questionarios"]);
        $questoes = $this->paginate($query);

        $this->set(compact("questoes"));
    }

    /**
     * View method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $questao = $this->Questoes->get($id, contain: ["Questionarios"]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->skipAuthorization();
        $this->set(compact("questao"));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questao = $this->Questoes->newEmptyEntity();
        $perguntas = $this->Questoes
            ->find()
            ->orderBy(["ordem" => "DESC"])
            ->contain(["Questionarios"])
            ->first();
        if ($perguntas->ordem) {
            $this->set("ordem", $perguntas->ordem + 1);
        }
        $this->Authorization->skipAuthorization();
        if ($this->request->is("post")) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__("Pergunta inserida."));
                return $this->redirect(["action" => "view", $questao->id]);
            }
            $this->Flash->error(__("Pergunta não inserida. Tente novamente."));
            return $this->redirect(["action" => "index"]);
        }
        $questionarios = $this->Questoes->Questionarios
            ->find("list", limit: 200)
            ->all();
        $this->set(compact("questao", "questionarios"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $questao = $this->Questoes->get($id, contain: []);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->skipAuthorization();
        if ($this->request->is(["patch", "post", "put"])) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__("Pergunta atualizada."));
                return $this->redirect(["action" => "view", $questao->id]);
            }
            $this->Flash->error(
                __("Pergunta não atualizada. Tente novamente."),
            );
            return $this->redirect(["action" => "index"]);
        }
        $questionarios = $this->Questoes->Questionarios
            ->find("list", limit: 200)
            ->all();
        $this->set(compact("questao", "questionarios"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $questao = $this->Questoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->skipAuthorization();
        if ($this->request->is(["post", "delete"])) {
            if ($this->Questoes->delete($questao)) {
                $this->Flash->success(__("Pergunta excluída."));
            } else {
                $this->Flash->error(__("Pergunta não excluída. Tente novamente."));
                return $this->redirect(["action" => "view", $questao->id]);
            }
        }
        return $this->redirect(["action" => "index"]);
    }
}
