<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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

        $this->Authentication->addUnauthenticatedActions(['view', 'index', 'indexold', 'busca', 'registro']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function indexold()
    {

        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'conditions' => ['nivel' => 4],
            'contain' => ['Tccestudantes', 'Estudantes'],
        ];
        $estagiariomonografias = $this->paginate($this->Estagiariomonografias);
        // pr($estagiarios);
        $this->set(compact('estagiariomonografias'));
    }

    /**
     * Lista method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

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
        }
        ;

        $periodo = $this->request->getSession()->read('periodo');
        // echo $periodo . "<br>";
        // die();
        if (!empty($periodo)):
            $estagiariomonografias = $this->Estagiariomonografias->find('all', [
                'conditions' => ['nivel' => 4, 'periodo' => $periodo],
                'contain' => ['Tccestudantes', 'Estudantes'],
            ]);
        else:
            $estagiariomonografias = $this->Estagiariomonografias->find('all', [
                'conditions' => ['nivel' => 4],
                'contain' => ['Tccestudantes', 'Estudantes'],
            ]);
        endif;
        $this->Authorization->authorize($this->Estagiariomonografias);
        // debug($estagiarios);
        // die('estagiarios');
        $periodos = $this->Estagiariomonografias->find('all', [
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
        $this->set('periodo', $periodo);
        $this->set('periodos', $totalperiodos);
        // die();
        $i = 0;
        // pr($estagiarios);
        $ordem = null;
        foreach ($estagiariomonografias as $c_estagiario):
            // pr($c_estagiario);
            // die();
            $estudantes[$i]['registro'] = $c_estagiario->registro;
            $estudantes[$i]['turno'] = $c_estagiario->turno;
            $estudantes[$i]['nivel'] = $c_estagiario->nivel;
            $estudantes[$i]['periodo'] = $c_estagiario->periodo;

            if (isset($c_estagiario->tccestudante['monografia_id']) && $c_estagiario->tccestudante['monografia_id']):
                $estudantes[$i]['id'] = $c_estagiario->tccestudante->id;
                $estudantes[$i]['nome'] = $c_estagiario->tccestudante->nome;

                $monografiastable = $this->fetchTable('Monografias');
                $monografia = $monografiastable->find('all', [
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
        // die('estudantes');
        if (isset($ordem) && !empty($ordem)):
            array_multisort($ordem, $direcao, $estudantes);
            $this->set(compact('estudantes'));
        else:
            $this->Flash->error(__('Não há estudantes que tenham concluído o 4 nivel no período: ' . $periodo));
            $this->redirect(['controller' => 'estagiariomonografias', 'action' => 'index']);
        endif;

        // die('sort');
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

        $Professores = $this->Estagiariomonografias->Docentes->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'limit' => 200
        ]);

        $this->set(compact('estagiariomonografia', 'alunos', 'Professores'));
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
