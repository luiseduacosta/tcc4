<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Agendamentotccs Controller
 *
 * @property \App\Model\Table\AgendamentotccsTable $Agendamentotccs
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Agendamentotccs           
 * @property \Cake\ORM\TableRegistry $Estudantes
 * @property \Cake\ORM\TableRegistry $Docentes
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendamentotccsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
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
            ->contain(['Alunos', 'Professores', 'Professorbanca1', 'Professorbanca2']);

        $agendamentotccs = $this->paginate($query, [
            'sortableFields' => [
                'Alunos.nome',
                'Professores.nome',
                'Professorbanca1.nome',
                'Professorbanca2.nome',
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
            'contain' => ['Alunos', 'Professores', 'Professorbanca1', 'Professorbanca2'],
        ]);
        $this->Authorization->skipAuthorization();
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
                $dados['horario'] .= ':00';
            endif;
            $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $dados);
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__('Agendamento TCC inserido.'));

                return $this->redirect(['action' => 'view', $agendamentotcc->id]);
            }
            $this->Flash->error(__('Agendamento TCC não foi inserido. Tente novamente'));
        }
        $alunos = $this->Agendamentotccs->Alunos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $alunos->order('nome');
        $professores = $this->Agendamentotccs->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $professores->order('nome');

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
            'contain' => ['Alunos', 'Professores', 'Professorbanca1', 'Professorbanca2'],
        ]);
        $this->Authorization->authorize($agendamentotcc);
        if ($this->request->is(['patch', 'post', 'put'])) {

            /* Ajusta o horário */
            $dados = $this->request->getData();
            $horarioarray = explode(':', $dados['horario']);
            if (empty($horarioarray[2])):
                $dados['horario'] .= ':00';
            endif;
            /* Finaliza ajuste de horario */

            $agendamentotcc = $this->Agendamentotccs->patchEntity($agendamentotcc, $dados);
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__('Agendamento TCC atualizado.'));

                return $this->redirect(['action' => 'view', $agendamentotcc->id]);
            }
            $this->Flash->error(__('Agendamento TCC não foi atualizado. Tente novamente.'));
        }
        $alunos = $this->Agendamentotccs->Alunos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $alunos->order(['nome' => 'asc']);
        $professores = $this->Agendamentotccs->Professores->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        $professores->order(['nome' => 'asc']);

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
