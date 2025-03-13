<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Agendamentotccs Controller
 *
 * @property \App\Model\Table\AgendamentotccsTable $Agendamentotccs
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *  
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendamentotccsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        // Permitir aos usuários se registrarem e efetuar logout.
        // Você não deve adicionar a ação de "login" a lista de permissões.
        // Isto pode causar problemas com o funcionamento normal do AuthComponent.
        // $this->Auth->allow(['logout']);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->Authorization->skipAuthorization();

        $query = $this->Agendamentotccs->find()
            ->contain(['Alunos', 'Professores', 'Professores1', 'Professores2']);

        $agendamentotccs = $this->paginate($query, [
            'sortableFields' => [
                'Alunos.nome',
                'Professores.nome',
                'Professores1.nome',
                'Professores2.nome',
                'Agendamentotccs.data',
                'Agendamentotccs.horario',
                'Agendamentotccs.sala',
                'Agendamentotccs.convidado',
                'Agendamentotccs.avaliacao'
            ]
        ]);

        $this->set(compact('agendamentotccs'));
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
        $agendamentotcc = $this->Agendamentotccs->get($id, [
            'contain' => ['Alunos', 'Professores', 'Professores1', 'Professores2'],
        ]);
        $this->Authorization->authorize($agendamentotcc);
        $this->set('agendamentotcc', $agendamentotcc);
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
        if ($this->request->is('post')) {
            // pr($this->request->getData());
            $dados = $this->request->getData();
            $horarioarray = explode(':', $dados['horario']);
            if (empty($horarioarray[2])):
                // echo "Horario incompleto" . "<br>";
                $dados['horario'] = $dados['horario'] . ':00';
            endif;
            $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $dados);
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__('Agendamento TCC inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Agendamento TCC não foi inserido. Tente novamente'));
        }
        $qalunos = $this->Agendamentotccs->Alunos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $qalunos->order('nome');
        $alunos = $qalunos->toArray();
        // pr($alunos);
        $qProfessores = $this->Agendamentotccs->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $qProfessores->order('nome');
        $professores = $qProfessores->toArray();

        $this->set(compact('agendamentotcc', 'alunos', 'professores'));
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
        $agendamentotcc = $this->Agendamentotccs->get($id, [
            'contain' => ['Alunos', 'Professores', 'Professores1', 'Professores2'],
        ]);
        $this->Authorization->authorize($agendamentotcc);
        if ($this->request->is(['patch', 'post', 'put'])) {

            /* Ajusta o horário */
            $dados = $this->request->getData();
            // pr($dados);
            // die();
            $horarioarray = explode(':', $dados['horario']);
            if (empty($horarioarray[2])):
                $dados['horario'] = $dados['horario'] . ':00';
            endif;
            // pr($dados);
            // die();
            /* Finaliza ajuste de horario */

            $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $dados);
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__('Agendamento TCC atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Agendamento TCC não foi atualizado. Tente novamente.'));
        }
        $qalunos = $this->Agendamentotccs->Alunos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $qalunos->order(['nome' => 'asc']);
        $alunos = $qalunos->toArray();
        $qProfessores = $this->Agendamentotccs->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $qProfessores->order('nome');
        $professores = $qProfessores->toArray();

        $this->set(compact('agendamentotcc', 'alunos', 'professores'));
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
        $this->request->allowMethod(['post', 'delete']);
        $agendamentotcc = $this->Agendamentotccs->get($id);
        $this->Authorization->authorize($agendamentotcc);
        if ($this->Agendamentotccs->delete($agendamentotcc)) {
            $this->Flash->success(__('Agendamento TCC foi excluído.'));
        } else {
            $this->Flash->error(__('Registro agendamento TCC não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
