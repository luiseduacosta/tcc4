<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;


/**
 * Tccestudantes Controller
 *
 * @property \App\Model\Table\TccestudantesTable $Tccestudantes
 *
 * @method \App\Model\Entity\Tccestudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * 
 * #[AllowDynamicProperties];
 */

class TccestudantesController extends AppController {

    public $Tccestudantes = null;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'order' => ['nome'],
            'contain' => ['Monografias'],
            'sortableFields' => ['Tccestudantes.id', 'Tccestudantes.registro', 'Tccestudantes.nome', 'Monografias.titulo']
        ];

        $tccestudantes = $this->paginate($this->Tccestudantes);
        // pr($tccestudantes);
        // die();
        $this->set(compact('tccestudantes'));
    }

    /**
     * View method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $this->loadModel('Tccestudantes'); // Estranho, mas necessário
        $tccestudante = $this->Tccestudantes->get($id, [
            'contain' => ['Monografias'],
        ]);
        $this->set('tccestudante', $tccestudante);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($estudante_id = null, $monografia_id = null) {

        // echo "Estudante id " . $estudante_id . '<br />';
        // echo "Monografia id " . $monografia_id;
        // die();
        if ($estudante_id):
            $registro = $estudante_id;

            /* Nome do aluno */
            $this->loadModel('Estudantes');
            $resultado = $this->Estudantes->find('all');
            $resultado->where(['registro' => $estudante_id]);
            $resultado->select(['nome']);
            $resultado->first();
            $nome = $resultado->first()->nome;
            // die();
            $this->set(compact('registro', 'nome'));
        endif;

        /* Titulo e id das monografias */
        $monografias = $this->Tccestudantes->Monografias->find(
                'list',
                ['keyField' => 'id', 'valueField' => 'titulo']
        );
        $monografias->order(['titulo' => 'asc']);
        // pr($monografias);
        // die();

        $tccestudante = $this->Tccestudantes->newEmptyEntity();
        $this->Authorization->authorize($tccestudante);
        if ($this->request->is('post')) {
            $tccaluno = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            // pr($tccestudante);
            // die();
            if ($this->Tccestudantes->save($tccaluno)) {
                $this->Flash->success(__('The tccestudante has been saved.'));

                return $this->redirect(['action' => 'view/' . $tccestudante->id]);
            }
            $this->Flash->error(__('The tccestudante could not be saved. Please, try again.'));
        }

        $this->set(compact('monografia_id', $monografia_id));
        $this->set(compact('monografias', 'tccestudante'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $tccestudante = $this->Tccestudantes->get($id, [
            'contain' => ['Monografias'],
        ]);
        // pr($tccestudante);
        // die();
        $this->Authorization->authorize($tccestudante);
        $monografias = $this->Tccestudantes->Monografias->find(
                'list',
                ['keyField' => 'id', 'valueField' => 'titulo']
        );
        $monografias->order(['titulo' => 'asc']);
        // pr($monografias);
        // die();
        // pr($tccestudante->monografia);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tccestudante = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            if ($this->Tccestudantes->save($tccestudante)) {
                $this->Flash->success(__('The tccestudante has been saved.'));

                return $this->redirect(['action' => 'view', $tccestudante->id]);
            }
            $this->Flash->error(__('The tccestudante could not be saved. Please, try again.'));
        }
        $this->set(compact('monografias', 'tccestudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        // pr($id);
        // die();
        $this->request->allowMethod(['post', 'delete']);
        $tccestudante = $this->Tccestudantes->get($id);
        $this->Authorization->authorize($tccestudante);
        if ($this->Tccestudantes->delete($tccestudante)) {
            $this->Flash->success(__('The tccestudante has been deleted.'));
        } else {
            $this->Flash->error(__('The tccestudante could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Busca Method
     *
     * @param null
     * @return string $estudantes
     */
    public function busca() {
        $this->Authorization->skipAuthorization();

        if ($this->request->is('post')) {
            // echo "Post" . "<br>";
            if ($this->request->getData()):
                $dados = $this->request->getData();
                $busca = $dados['nome'];
                // echo $busca;
                // die();
                $this->getRequest()->getSession()->write('estudante', $busca);
                // $this->request->session()->write('estudante', $busca);
                $this->paginate = [
                    'conditions' => ['nome LIKE' => "%" . $busca . "%"],
                    'order' => ['nome'],
                    'contain' => ['Monografias']
                ];
            endif;
        };

        if (!isset($busca)):

            $busca = $this->getRequest()->getSession()->read('estudante');
            // echo $busca;
            // die();
            if (!empty($busca)):
                $this->paginate = [
                    'conditions' => ['nome LIKE' => "%" . $busca . "%"],
                    'order' => ['nome'],
                    'contain' => ['Monografias']
                ];
            else:
                $this->paginate = [
                    'order' => ['nome'],
                    'contain' => ['Monografias']
                ];
            endif;
        endif;

        $estudantes = $this->paginate($this->Tccestudantes);
        // debug($estudantes);
        // die();
        $this->set(compact('estudantes'));
    }
}
