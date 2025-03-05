<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Areas Controller
 *
 * @property \App\Model\Table\AreasTable $Areas
 *
 * @method \App\Model\Entity\Area[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreamonografiasController extends AppController {

    public $Monografias = null;
    public $Docentes = null;
    public $Tccestudantes = null;
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $this->Authorization->skipAuthorization();

        $query = $this->Areamonografias->find()->contain(['Monografias']);
        $areas = $this->paginate($query);
        $this->set(compact('areas'));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $area = $this->Areamonografias->get($id, [
            'contain' => ['Docentes', 'Monografias'],
        ]);
        // pr($area->monografias);
        $this->loadModel('Docentes');
        $this->loadModel('Tccestudantes');
        $i = 0;
        foreach ($area->monografias as $monografias):
            // pr($monografias['id']);
            // die();
            $docente = $this->Docentes->find('all', [
                'conditions' => ['Docentes.id' => $monografias['docente_id']]]);
            $docentenome = $docente->first();

            $tccestudante = $this->Tccestudantes->find('all', [
                'conditions' => ['Tccestudantes.monografia_id' => $monografias['id']]]);
            // pr($tccestudante);
            $estudanteareamonografias = $tccestudante->all();

            $estudantenome = null;
            $estudantenome_id = null;
            if (sizeof($estudanteareamonografias) > 1):
                // echo sizeof($estudanteareamonografias);
                foreach ($estudanteareamonografias as $c_tccestudante):
                    // pr($c_tccestudante);
                    $estudantenome[] = $c_tccestudante['nome'] . ", ";
                    $estudantenome_id[] = $c_tccestudante['id'];
                endforeach;
            else:
                foreach ($estudanteareamonografias as $c_tccestudante):
                    // pr($c_tccestudante);
                    $estudantenome = $c_tccestudante['nome'];
                    $estudantenome_id = $c_tccestudante['id'];
                endforeach;
            endif;
            // pr($estudantenome);
            $monografiasrelacionadas[$i]['id'] = $monografias['id'];
            $monografiasrelacionadas[$i]['titulo'] = $monografias['titulo'];
            $monografiasrelacionadas[$i]['periodo'] = $monografias['periodo'];
            $monografiasrelacionadas[$i]['docente'] = $docentenome['nome'];
            $monografiasrelacionadas[$i]['docente_id'] = $docentenome['id'];
            $monografiasrelacionadas[$i]['estudante'] = $estudantenome;
            $monografiasrelacionadas[$i]['estudante_id'] = $estudantenome_id;
            $i++;
            // die();

        endforeach;
        // pr($monografiasrelacionadas);
        // die();
        if (isset($monografiasrelacionadas) && !(empty($monografiasrelacionadas))):
            $this->set('monografiasrelacionadas', $monografiasrelacionadas);
        endif;
        $this->set('area', $area);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $area = $this->Areamonografias->newEmptyEntity();
        $this->Authorization->authorize($area);

        if ($this->request->is('post')) {
            $area = $this->Areamonografias->patchEntity($area, $this->request->getData());
            if ($this->Areamonografias->save($area)) {
                $this->Flash->success(__('The area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The area could not be saved. Please, try again.'));
        }
        $docentes = $this->Areamonografias->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('area', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $area = $this->Areamonografias->get($id, [
            'contain' => ['Docentes'],
        ]);
        $this->Authorization->authorize($area);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $area = $this->Areamonografias->patchEntity($area, $this->request->getData());
            if ($this->Areamonografias->save($area)) {
                $this->Flash->success(__('The area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The area could not be saved. Please, try again.'));
        }
        $docentes = $this->Areamonografias->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('area', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $areamonografia = $this->Areamonografias->get($id);
        $this->Authorization->authorize($areamonografia);

        if ($this->Areamonografias->delete($areamonografia)) {
            $this->Flash->success(__('The area has been deleted.'));
        } else {
            $this->Flash->error(__('The area could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
