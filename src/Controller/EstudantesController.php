<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Estudantes Controller
 *
 * @property \App\Model\Table\EstudantesTable $Estudantes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstudantesController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Permitir aos usuários se registrarem e efetuar logout.
        // Você não deve adicionar a ação de "login" a lista de permissões.
        // Isto pode causar problemas com o funcionamento normal do AuthComponent.
        // $this->Auth->allow(['logout']);
        $this->Authentication->addUnauthenticatedActions([
            'index',
            'view',
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index(): ?Response
    {
        $this->Authorization->skipAuthorization();
        $estudantes = $this->Estudantes->find()->contain(['Tccestudantes']);
        if ($estudantes->all()->isEmpty()) {
            $this->Flash->warning(__('Nenhum estudante de TCC encontrado.'));

            return $this->redirect(['action' => 'add']);
        }
        $alunos = $estudantes->orderBy(['Estudantes.nome' => 'ASC'])->all();
        $this->set('alunos', $alunos);
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): ?Response
    {
        $estudante = $this->Estudantes
            ->find()
            ->contain([
                'Tccestudantes' => ['Monografias'],
            ])
            ->where(['Estudantes.id' => $id])
            ->first();

        if (!$estudante) {
            $this->Flash->error(
                __('Usuário estudante cadastrado não encontrado.'),
            );

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->skipAuthorization();
        $this->set('estudante', $estudante);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $estudante = $this->Estudantes->newEmptyEntity();
        $this->Authorization->authorize($estudante);

        if ($this->request->is('post')) {
            $estudante = $this->Estudantes->patchEntity(
                $estudante,
                $this->request->getData(),
            );
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Estudante registrado.'));

                return $this->redirect(['action' => 'view', $estudante->id]);
            }
            $this->Flash->error(
                __('Não foi possível registrar o estudante. Tente novamente.'),
            );
        }
        $this->set(compact('estudante'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): ?Response
    {
        try {
            $estudante = $this->Estudantes->get($id, contain: []);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($estudante);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudante = $this->Estudantes->patchEntity(
                $estudante,
                $this->request->getData(),
            );
            // debug($estudanteatualiza);
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Estudante atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Estudante não foi atualizado.'));
        }
        $this->set(compact('estudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $estudante = $this->Estudantes->get($id, contain: ['Tccestudantes']);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($estudante);

        if ($estudante->tccestudante) {
            $this->Flash->error(
                __(
                    'Registro de estudante não excluído. O estudante possui registro de TCC.',
                ),
            );

            return $this->redirect(['action' => 'view', $id]);
        }
        if ($this->Estudantes->delete($estudante)) {
            $this->Flash->success(__('Registro de estudante excluído.'));
        } else {
            $this->Flash->error(__('Registro de estudante não excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
