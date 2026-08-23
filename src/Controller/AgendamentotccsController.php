<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Agendamentotccs Controller
 *
 * @property \App\Model\Table\AgendamentotccsTable $Agendamentotccs
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \App\Model\Table\EstudantesTable $Estudantes
 * @property \App\Model\Table\ProfessoresTable $Professores
 *
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendamentotccsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(["index", "view"]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query = $this->Agendamentotccs
            ->find()
            ->contain([
                "Estudantes",
                "Professores",
                "ProfessoresBanca1",
                "ProfessoresBanca2",
            ]);

        if ($this->request->getQuery("sort") === null) {
            $query->orderBy(["Estudantes.nome" => "ASC"]);
        }

        $agendamentotccs = $this->paginate($query, [
            "sortableFields" => [
                "Estudantes.nome",
                "Professores.nome",
                "ProfessoresBanca1.nome",
                "ProfessoresBanca2.nome",
                "Agendamentotccs.data",
                "Agendamentotccs.horario",
                "Agendamentotccs.sala",
                "Agendamentotccs.convidado",
                "Agendamentotccs.avaliacao",
            ],
        ]);

        $this->set(compact("agendamentotccs"));
    }

    /**
     * View method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id, contain: [
                    "Estudantes",
                    "Professores",
                    "ProfessoresBanca1",
                    "ProfessoresBanca2",
                ],);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        $this->set("agendamentotcc", $agendamentotcc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $agendamentotcc = $this->Agendamentotccs->newEmptyEntity();
        $this->Authorization->authorize($agendamentotcc);

        if ($this->request->is("post", "put", "patch")) {
            $dados = $this->request->getData();
            /* Ajusta o horário */
            $horarioarray = explode(":", $dados["horario"]);
            if (empty($horarioarray[2])):
                $dados["horario"] .= ":00";
            endif;
            
            $agendamentotcc = $this->Agendamentotccs->patchEntity(
                $agendamentotcc,
                $dados,
            );
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__("Agendamento TCC inserido."));
                return $this->redirect([
                    "action" => "view",
                    $agendamentotcc->id,
                ]);
            }
            $this->Flash->error(
                __("Agendamento TCC não foi inserido. Tente novamente"),
            );
        }

        $estudantes = $this->Agendamentotccs->Estudantes->find("list",
            keyField: "id",
            valueField: "nome",
            order: ["nome" => "asc"]
        );

        $professores = $this->Agendamentotccs->Professores->find("list",
            keyField: "id",
            valueField: "nome",
            order: ["nome" => "asc"]
        );

        $this->set(compact("agendamentotcc", "estudantes", "professores"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id, contain: [
                    "Estudantes",
                    "Professores",
                    "ProfessoresBanca1",
                    "ProfessoresBanca2",
                ],);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        if ($this->request->is(["patch", "post", "put"])) {
            /* Ajusta o horário */
            $dados = $this->request->getData();
            $horarioarray = explode(":", $dados["horario"]);
            if (empty($horarioarray[2])):
                $dados["horario"] .= ":00";
            endif;
            /* Finaliza ajuste de horario */

            $agendamentotcc = $this->Agendamentotccs->patchEntity(
                $agendamentotcc,
                $dados,
            );
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__("Agendamento TCC atualizado."));
                return $this->redirect([
                    "action" => "view",
                    $agendamentotcc->id,
                ]);
            }
            $this->Flash->error(
                __("Agendamento TCC não foi atualizado. Tente novamente."),
            );
        }
        $estudantes = $this->Agendamentotccs->Estudantes->find("list",
            keyField: "id",
            valueField: "nome",
            order: ["nome" => "asc"]
        );
        $professores = $this->Agendamentotccs->Professores->find("list",
            keyField: "id",
            valueField: "nome",
            order: ["nome" => "asc"]
        );

        $this->set(compact("agendamentotcc", "estudantes", "professores"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        if ($this->request->allowMethod(["post", "delete"])) {
            if ($this->Agendamentotccs->delete($agendamentotcc)) {
                $this->Flash->success(__("Agendamento TCC foi excluído."));
            } else {
                $this->Flash->error(
                    __(
                        "Registro agendamento TCC não foi excluído. Tente novamente.",
                    ),
                );
            }
            return $this->redirect(["action" => "index"]);
        }
    }
}
