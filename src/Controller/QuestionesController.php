<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Questiones Controller
 *
 * @property \App\Model\Table\QuestionesTable $Questiones
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionesController extends AppController
{
    public $paginate = [
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
        $query = $this->Questiones->find()->contain(["Questionarios"]);
        $questiones = $this->paginate($query);

        $this->set(compact("questiones"));
    }

    /**
     * View method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questione = $this->Questiones->get($id, [
            "contain" => ["Questionarios"],
        ]);
        $this->Authorization->skipAuthorization();
        $this->set(compact("questione"));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // pr($this->request->getData());
        $questione = $this->Questiones->newEmptyEntity();
        $perguntas = $this->Questiones
            ->find()
            ->order(["ordem" => "DESC"])
            ->contain(["Questionarios"])
            ->first();
        if ($perguntas->ordem) {
            $this->set("ordem", $perguntas->ordem + 1);
        }
        $this->Authorization->skipAuthorization();
        if ($this->request->is("post")) {
            $questione = $this->Questiones->patchEntity(
                $questione,
                $this->request->getData(),
            );
            if ($this->Questiones->save($questione)) {
                $this->Flash->success(__("Pergunta inserida."));
                return $this->redirect(["action" => "view", $questione->id]);
            }
            $this->Flash->error(__("Pergunta não inserida. Tente novamente."));
            return $this->redirect(["action" => "index"]);
        }
        $questionarios = $this->Questiones->Questionarios
            ->find("list", ["limit" => 200])
            ->all();
        $this->set(compact("questione", "questionarios"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questione = $this->Questiones->get($id, [
            "contain" => [],
        ]);
        $this->Authorization->skipAuthorization();
        if ($this->request->is(["patch", "post", "put"])) {
            $questione = $this->Questiones->patchEntity(
                $questione,
                $this->request->getData(),
            );
            if ($this->Questiones->save($questione)) {
                $this->Flash->success(__("Pergunta atualizada."));
                return $this->redirect(["action" => "view", $questione->id]);
            }
            $this->Flash->error(
                __("Pergunta não atualizada. Tente novamente."),
            );
            return $this->redirect(["action" => "index"]);
        }
        $questionarios = $this->Questiones->Questionarios
            ->find("list", ["limit" => 200])
            ->all();
        $this->set(compact("questione", "questionarios"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questione id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        $questione = $this->Questiones->get($id);
        $this->Authorization->skipAuthorization();
        if ($this->Questiones->delete($questione)) {
            $this->Flash->success(__("Pergunta excluída."));
        } else {
            $this->Flash->error(__("Pergunta não excluída. Tente novamente."));
            return $this->redirect(["action" => "view", $questione->id]);
        }
        return $this->redirect(["action" => "index"]);
    }
}
