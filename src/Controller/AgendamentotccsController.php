<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Agendamentotccs Controller
 *
 * @property \App\Model\Table\AgendamentotccsTable $Agendamentotccs
 *
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendamentotccsController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {

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
    public function index() {

        $this->Authorization->skipAuthorization();

        $this->paginate['contain'] = ['Estudantes', 'Docentes', 'Docentes1', 'Docentes2'];
        $this->paginate['sortWhitelist'] = ['Alunos.nome',
            'Docentes.nome',
            'Docentes1.nome',
            'Docentes2.nome',
            'Agendamentotccs.data',
            'Agendamentotccs.horario',
            'Agendamentotccs.sala',
            'Agendamentotccs.convidado',
            'Agendamentotccs.avaliacao']
        ;
        $agendamentotccs = $this->paginate($this->Agendamentotccs);

        $this->set(compact('agendamentotccs'));
    }

    /**
     * View method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $agendamentotcc = $this->Agendamentotccs->get($id, [
            'contain' => ['Estudantes', 'Docentes', 'Docentes1', 'Docentes2'],
        ]);

        $this->set('agendamentotcc', $agendamentotcc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

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
            // $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $this->request->getData());
            $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $dados);
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__('The agendamentotcc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agendamentotcc could not be saved. Please, try again.'));
        }
        $qalunos = $this->Agendamentotccs->Estudantes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome'
        ]);
        $qalunos->order('nome');
        $alunos = $qalunos->toArray();
        // pr($alunos);
        $qdocentes = $this->Agendamentotccs->Docentes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome']);
        $qdocentes->order('nome');
        $docentes = $qdocentes->toArray();

        $this->set(compact('agendamentotcc', 'alunos', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $agendamentotcc = $this->Agendamentotccs->get($id, [
            'contain' => ['Estudantes', 'Docentes', 'Docentes1', 'Docentes2'],
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
                $this->Flash->success(__('The agendamentotcc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agendamentotcc could not be saved. Please, try again.'));
        }
        $qalunos = $this->Agendamentotccs->Estudantes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome']);
        $qalunos->order(['nome' => 'asc']);
        $alunos = $qalunos->toArray();
        $qdocentes = $this->Agendamentotccs->Docentes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome']);
        $qdocentes->order('nome');
        $docentes = $qdocentes->toArray();

        $this->set(compact('agendamentotcc', 'alunos', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $agendamentotcc = $this->Agendamentotccs->get($id);
        $this->Authorization->authorize($agendamentotcc);
        if ($this->Agendamentotccs->delete($agendamentotcc)) {
            $this->Flash->success(__('The agendamentotcc has been deleted.'));
        } else {
            $this->Flash->error(__('The agendamentotcc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
