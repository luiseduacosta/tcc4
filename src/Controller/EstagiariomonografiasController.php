<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
/**
 * Estagiariomonografias Controller
 *
 * @property \App\Model\Table\EstagiariomonografiasTable $Estagiariomonografias
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Estagiariomonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariomonografiasController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {

        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['view', 'index', 'busca', 'registro']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setTemplate('index');

        $periodo = $this->request->getQuery('periodo');
        $periodos = $this->Estagiariomonografias->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ])
        ->order(['periodo' => 'ASC']);
        $periodos = $periodos->toArray();
        if (empty($periodo)) {
            $periodo = end($periodos); // Pega o último elemento do array
        }

        // $periodo = '2008-1';
        $estagiariomonografias = $this->Estagiariomonografias->find('all', [
            'fields' => ['Estudantes.id', 'Estudantes.nome', 'Estudantes.registro', 'Estagiariomonografias.id', 'Estagiariomonografias.periodo', 'Estagiariomonografias.ajuste2020', 'Estagiariomonografias.nivel', 'Tccestudantes.monografia_id', 'Tccestudantes.registro', 'Tccestudantes.id', 'Tccestudantes.nome', 'Monografias.id', 'Monografias.titulo', 'Monografias.periodo'],
            'conditions' => ['or' => [['ajuste2020' => '0', 'nivel' => 4], ['ajuste2020' => '1', 'nivel' => 3]], 
            'Estagiariomonografias.periodo' => $periodo],
            'contain' => ['Estudantes', 'Tccestudantes' => ['Monografias']],
            'order' => ['Estudantes.nome' => 'ASC']
        ]);
        $this->set(compact('estagiariomonografias', 'periodo', 'periodos'));
    }

    /**
     * Indexb method
     *
     * @param string|null $periodo
     * @return \Cake\Http\Response|null
     */
    public function indexbak($periodo = null)
    {
        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $periodo = $this->request->getData('periodo');
        } else {
            $periodo = $this->request->getQuery('periodo');
        }
        $periodos = $this->Estagiariomonografias->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ])
        ->order(['periodo' => 'DESC']);

        if (empty($periodo)) {
            $periodo = end($periodos); // Pega o último elemento do array
        }

        $this->set('periodo', $periodo);
        $this->set('periodos', $periodos->toArray());

        if ($periodo) {
            $estagiariomonografias = $this->Estagiariomonografias->find();
            $estagiariomonografias = $estagiariomonografias->where([
                'Estagiariomonografias.periodo' => $periodo
            ]);
            $estagiariomonografias = $estagiariomonografias->where([
                'or' => [
                    ['ajuste2020' => '0', 'nivel' => 4],
                    ['ajuste2020' => '1', 'nivel' => 3]
                ]
            ]);
        } else {
            $estagiariomonografias = $this->Estagiariomonografias->find();
            $estagiariomonografias = $estagiariomonografias->where([
                'or' => [
                    ['ajuste2020' => '0', 'nivel' => 4],
                    ['ajuste2020' => '1', 'nivel' => 3]
                ]
            ]);
        }
        $estagiariomonografias = $estagiariomonografias->contain(['Estudantes' => ['Tccestudantes' => ['Monografias']]]);
        if (empty($estagiariomonografias->toArray())) {
            $this->Flash->error(__('Nenhum registro encontrado para o período ' . $periodo . ' selecionado.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $estagiariomonografias = $estagiariomonografias->toArray();
            $this->set(compact('estagiariomonografias', 'periodo', 'periodos'));
        }
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $estagiariomonografia = $this->Estagiariomonografias->get($id, [
            'contain' => ['Estudantes', 'Docentemonografias'],
        ]);
        $this->Authorization->authorize($estagiariomonografia);
        $this->set('estagiariomonografia', $estagiariomonografia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $estagiariomonografia = $this->Estagiariomonografias->newEmptyEntity();
        $this->Authorization->authorize($estagiariomonografia);
        if ($this->request->is('post')) {
            $estagiariomonografia = $this->Estagiariomonografias->patchEntity($estagiariomonografia, $this->request->getData());
            if ($this->Estagiariomonografias->save($estagiariomonografia)) {
                $this->Flash->success(__('Registros de estagiário inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro estagiário não foi inserido. Tente novamente.'));
        }
        $alunos = $this->Estagiariomonografias->Estudantes->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'limit' => 200
        ]);

        $professores = $this->Estagiariomonografias->Docentes->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'limit' => 200
        ]);

        $this->set(compact('estagiariomonografia', 'alunos', 'professores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        // $this->autoRender = false;
        $estagiariomonografia = $this->Estagiariomonografias->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estagiariomonografia);
        // pr($estagiario);
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiariomonografia = $this->Estagiariomonografias->patchEntity($estagiariomonografia, $this->request->getData());
            if ($this->Estagiariomonografias->save($estagiariomonografia)) {
                $this->Flash->success(__('Estagiário atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Estagiário não foi atualizado. Tente novamente.'));
        }
        $alunos = $this->Estagiariomonografias->Estudantes->find(
            'list',
            [
                'keyField' => 'id',
                'valueField' => 'nome',
                'limit' => 200
            ]
        );
        // debug($alunos);
        // die("alunos");
        $docentemonografias = $this->Estagiariomonografias->Docentes->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'limit' => 200
        ]);
        $areas = $this->Estagiariomonografias->Areaestagios->find('list', [
            'keyField' => 'id',
            'valueField' => 'area',
            'limit' => 200
        ]);

        $this->set(compact('estagiariomonografia', 'alunos', 'docentemonografias', 'areas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $estagiariomonografia = $this->Estagiariomonografias->get($id);
        $this->Authorization->authorize($estagiariomonografia);

        if ($this->Estagiariomonografias->delete($estagiariomonografia)) {
            $this->Flash->success(__('Registro estagiário excluído.'));
        } else {
            $this->Flash->error(__('Registro estagiário não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function busca($busca = null)
    {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        if ($busca):
            echo "Buscar: " . $busca . "<br>";
        else:
            echo 'Digitar a busca';
        endif;
        // die();
    }

    public function registro($id = null)
    {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;

        if ($this->request->is('ajax')):
            $this->autoRender = false;
            $estagiariomonografia = $this->Estagiariomonografias->get($id);
            $registro = $estagiariomonografia->registro;
            if ($registro):
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(
                        json_encode([
                            'registro' => $registro
                        ])
                    );
            endif;
        endif;
    }

}
