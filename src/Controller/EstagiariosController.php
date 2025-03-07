<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use phpDocumentor\Reflection\Types\Null_;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 *
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController {
    /*
      public function beforeFilter(\Cake\Event\EventInterface $event): Event
      {

      parent::beforeFilter($event);

      // $this->Auth->allow(['view', 'index', 'indexold', 'busca', 'registro']);
      }
     */

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function indexold() {
        // echo "index" . "<br>";
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'conditions' => ['nivel' => 4],
            'contain' => ['Tccestudantes', 'Estudantes'],
        ];
        $estagiarios = $this->paginate($this->Estagiarios);
        // pr($estagiarios);
        $this->set(compact('estagiarios'));
    }

    /**
     * Lista method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $this->Authorization->skipAuthorization();
        $parametros = $this->request->getQueryParams();
        // pr($parametros);
        // die();
        if (!empty($parametros)):
            $criterio = $parametros['sort'];
            $orientacao = $parametros['direction'];
            $direcao = $orientacao == 'asc' ? SORT_ASC : SORT_DESC;
        else:
            $criterio = 'nome';
            $direcao = SORT_ASC;
        endif;
        // echo $criterio;
        // echo $direcao;
        // die();

        if ($this->request->is('post')) {
            // echo "Post" . "<br>";
            if ($this->request->getData()):
                $dados = $this->request->getData();
                $periodo = $dados['periodo'];
                $this->request->getSession()->write('periodo', $periodo);
            endif;
        };

        $periodo = $this->request->getSession()->read('periodo');
        // echo $periodo . "<br>";
        // die();
        if (!empty($periodo)):
            $estagiarios = $this->Estagiarios->find('all', [
                'conditions' => ['nivel' => 4, 'periodo' => $periodo],
                'contain' => ['Tccestudantes', 'Estudantes'],
            ]);
        else:
            $estagiarios = $this->Estagiarios->find('all', [
                'conditions' => ['nivel' => 4],
                'contain' => ['Tccestudantes', 'Estudantes'],
            ]);
        endif;

        // debug($estagiarios);
        // die('estagiarios');
        $periodos = $this->Estagiarios->find('all', [
            'conditions' => ['nivel' => 4],
            'fields' => ['periodo'],
            'group' => ['periodo']
        ]);
        // pr($periodos);
        // die('periodos');
        foreach ($periodos as $c_periodo):
            $totalperiodos[$c_periodo['periodo']] = $c_periodo['periodo'];
        endforeach;
        // die();
        // pr($totalperiodos);
        $this->set('periodos', $totalperiodos);
        // die();
        $i = 0;
        // pr($estagiarios);
        $ordem = null;
        foreach ($estagiarios as $c_estagiario):
            // pr($c_estagiario->tccestudante->monografia_id);
            $estudantes[$i]['registro'] = $c_estagiario->registro;
            $estudantes[$i]['turno'] = $c_estagiario->turno;
            $estudantes[$i]['nivel'] = $c_estagiario->nivel;
            $estudantes[$i]['periodo'] = $c_estagiario->periodo;

            if (!empty($c_estagiario->tccestudante)):
                $estudantes[$i]['id'] = $c_estagiario->tccestudante->id;
                $estudantes[$i]['nome'] = $c_estagiario->tccestudante->nome;

                $this->loadModel('Monografias');
                $monografia = $this->Monografias->find('all', [
                    'conditions' => ['Monografias.id' => $c_estagiario->tccestudante->monografia_id]
                ]);
                // pr($monografia);
                $totalmonografia = $monografia->first();
                // debug($totalmonografia);
                // die();
                $estudantes[$i]['monografia_id'] = $c_estagiario->tccestudante->monografia_id;
                $estudantes[$i]['titulo'] = $totalmonografia['titulo'];
                $estudantes[$i]['periodo_monog'] = $totalmonografia['periodo'];
                $ordem[$i][$criterio] = $estudantes[$i][$criterio];
            // die();
            else:
                $estudantes[$i]['nome'] = $c_estagiario->estudante['nome'];
                $estudantes[$i]['registro'] = $c_estagiario->estudante['registro'];
                $estudantes[$i]['monografia_id'] = '';
                $estudantes[$i]['titulo'] = '';
                $estudantes[$i]['periodo_monog'] = '';
                $ordem[$i][$criterio] = $estudantes[$i][$criterio];
            endif;

            // die();
            $i++;
        endforeach;
        // pr($ordem);
        // pr($estudantes);
        // die('estudantes');
        if (isset($ordem) && !empty($ordem)):
            array_multisort($ordem, $direcao, $estudantes);
            $this->set(compact('estudantes'));
        else:
            $this->Flash->error(__('Não há estudantes que tenham concluído o 4 nivel no período: ' . $periodo));
            $this->redirect(['controller' => 'estagiarios', 'action' => 'index']);
        endif;
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Estudantes', 'Docentes'],
        ]);

        $this->set('estagiario', $estagiario);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $estagiario = $this->Estagiarios->newEmptyEntity();
        $this->Authorization->authorize($estagiario);
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Estagiário inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Estagiário não foi inserido. Tente novamente.'));
        }
        $alunos = $this->Estagiarios->Estudantes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $supervisores = $this->Estagiarios->Supervisores->find('list', [
            'keyField' => 'id', 'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $instituicoes = $this->Estagiarios->Instituicaoestagios->find('list', [
            'keyField' => 'id', 'valueField' => 'instituicao',
            'order' => 'instituicao',
            'limit' => 200
        ]);

        $docentes = $this->Estagiarios->Docentes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome',
            'order' => 'nome',
            'limit' => 200
        ]);

        $areaestagios = $this->Estagiarios->Areaestagios->find('list', [
            'keyField' => 'id', 'valueField' => 'area',
            'order' => 'area',
            'limit' => 200
        ]);
        
        $this->set(compact('estagiario', 'alunos', 'docentes', 'supervisores', 'instituicoes', 'areaestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        // $this->autoRender = false;
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($estagiario);
        // pr($estagiario);
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Estudantes->find('list',
                ['keyField' => 'id', 'valueField' => 'nome',
                    'limit' => 200]
        );
        // debug($alunos);
        // die("alunos");
        $docentes = $this->Estagiarios->Docentes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome',
            'limit' => 200
        ]);
        $areas = $this->Estagiarios->Areas->find('list', [
            'keyField' => 'id', 'valueField' => 'area',
            'limit' => 200
        ]);

        $this->set(compact('estagiario', 'alunos', 'docentes', 'areas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        $this->Authorization->authorize($estagiario);

        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('The estagiario has been deleted.'));
        } else {
            $this->Flash->error(__('The estagiario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function busca($busca = null) {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        if ($busca):
            echo "Buscar: " . $busca . "<br>";
        else:
            echo 'Digitar a busca';
        endif;
        // die();
    }

    public function registro($id = null) {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;

        if ($this->request->is('ajax')):
            $this->autoRender = false;
            $dre = $this->Estagiarios->get($id);
            $registro = $dre->registro;
            if ($registro):
                return $this->response
                                ->withType('application/json')
                                ->withStringBody(json_encode([
                                    'registro' => $registro])
                                );
            endif;
        endif;
    }
}
