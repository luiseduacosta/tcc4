<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        $alunos = $this->paginate($this->Alunos);
        $this->Authorization->authorize($this->Alunos);
        $this->set(compact('alunos'));
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        if (is_null($id)) {
            $registro = $this->getRequest()->getQuery('registro');
            $alunoquery = $this->Alunos->find()->where(['alunos.registro' => $registro])->select('alunos.id');
            $aluno = $alunoquery->first();

            if (empty($aluno)) {
                echo "Sem parámentros para localizar o aluno";
                $this->Flash->error(__('Sem parámentros para localizar o/a aluno/a'));
                return $this->redirect('/alunos/index');
            } else {
                $id = $aluno->id;
            }
        }
        $aluno = $this->Alunos->get($id, [
            'contain' => ['Estagiarios' => ['Instituicaoestagios', 'Alunos', 'Estudantes', 'Supervisores', 'Docentes', 'Areaestagios'], 'Muralinscricoes' => 'Muralestagios'],
        ]);
        $this->Authorization->authorize($aluno);
        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $aluno = $this->Alunos->newEmptyEntity();
        $this->Authorization->authorize($aluno);
        if ($this->request->is('post')) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('The aluno has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $aluno = $this->Alunos->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($aluno);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('The aluno has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $aluno = $this->Alunos->get($id);
        $this->Authorization->authorize($aluno);
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('The aluno has been deleted.'));
        } else {
            $this->Flash->error(__('The aluno could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
