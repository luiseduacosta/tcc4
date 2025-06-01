<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Areamonografias Controller
 *
 * @property \App\Model\Table\AreamonografiasTable $Areamonografias
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Areamonografias
 * @property \Cake\ORM\TableRegistry $Docentes
 * @property \Cake\ORM\TableRegistry $Monografias
 * 
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreamonografiasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

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
    public function view($id = null)
    {

        $this->Authorization->skipAuthorization();
        $areamonografia = $this->Areamonografias->get($id, [
            'contain' => ['Docentes', 'Monografias' => ['Tccestudantes', 'Docentes']],
        ]);

        $this->set('areamonografia', $areamonografia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $area = $this->Areamonografias->newEmptyEntity();
        $this->Authorization->authorize($area);

        if ($this->request->is('post')) {
            $area = $this->Areamonografias->patchEntity($area, $this->request->getData());
            if ($this->Areamonografias->save($area)) {
                $this->Flash->success(__('Área de monografia inserida.'));

                return $this->redirect(['action' => 'view', $area->id]);
            }
            $this->Flash->error(__('Área de monografia não inserida.'));
        }
        $docentes = $this->Areamonografias->Docentes->find('list');
        $this->set(compact('area', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $areamonografia = $this->Areamonografias->get($id, [
            'contain' => ['Professores'],
        ]);
        $this->Authorization->authorize($areamonografia);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $area = $this->Areamonografias->patchEntity($areamonografia, $this->request->getData());
            if ($this->Areamonografias->save($area)) {
                $this->Flash->success(__('Área de monografia atualizada.'));

                return $this->redirect(['action' => 'view', $area->id]);
            }
            $this->Flash->error(__('Área de monografia não foi atualizada.'));
        }
        $docentes = $this->Areamonografias->Docentes->find('list');
        $this->set(compact('areamonografia', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $areamonografia = $this->Areamonografias->get($id);
        $this->Authorization->authorize($areamonografia);

        if ($this->Areamonografias->delete($areamonografia)) {
            $this->Flash->success(__('Área da mongrafia excluída.'));
        } else {
            $this->Flash->error(__('Área da monografia não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
