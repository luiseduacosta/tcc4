<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use function in_array;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 */
class ProfessoresController extends AppController
{
    private const STATUS_LABELS = [
        'ativo' => 'Ativo',
        'aposentado' => 'Aposentado',
        'inativo' => 'Inativo',
    ];

    private const STATUS_ALIASES = [
        'ativo' => ['ativo', 'active', 'activo'],
        'aposentado' => ['aposentado', 'retired'],
        'inativo' => ['inativo', 'inactive', 'inactivo'],
    ];

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'buscaprofessor']);
    }

    public function index(): void
    {
        $this->Authorization->skipAuthorization();

        $statusFilter = $this->request->getQuery('status');
        $departamentoFilter = $this->request->getQuery('departamento');

        $departamentos = $this->Professores->find()
            ->select(['departamento'])
            ->distinct(['departamento'])
            ->where(['departamento IS NOT' => null])
            ->orderBy(['departamento' => 'ASC'])
            ->toArray();

        $departamentosList = [];
        foreach ($departamentos as $departamento) {
            $departamentosList[$departamento->departamento] = $departamento->departamento;
        }

        $status = $this->Professores->find()
            ->select(['status'])
            ->distinct(['status'])
            ->where(['status IS NOT' => null])
            ->orderBy(['status' => 'ASC'])
            ->toArray();

        $statusList = [];
        foreach ($status as $statusItem) {
            $canonicalStatus = $this->canonicalStatus((string)$statusItem->status);
            $statusList[$canonicalStatus] = self::STATUS_LABELS[$canonicalStatus] ?? $canonicalStatus;
        }
        asort($statusList);

        $query = $this->Professores->find();

        if ($statusFilter) {
            $canonical = $this->canonicalStatus($statusFilter);
            $aliases = self::STATUS_ALIASES[$canonical] ?? [$canonical];
            $query->where(['Professores.status IN' => $aliases]);
        }

        if ($departamentoFilter) {
            $query->where(['Professores.departamento' => $departamentoFilter]);
        }

        $config = [
            'order' => ['nome' => 'ASC'],
            'sortableFields' => [
                'id',
                'nome',
                'cpf',
                'siape',
                'departamento',
                'status',
                'email',
            ],
        ];

        $professores = $this->paginate($query, $config);
        $statusFilterLabel = $statusFilter ? (self::STATUS_LABELS[$this->canonicalStatus($statusFilter)] ?? $statusFilter) : null;

        $this->set(compact(
            'professores',
            'departamentosList',
            'statusList',
            'statusFilter',
            'statusFilterLabel',
            'departamentoFilter',
        ));
    }

    public function view(?string $id = null): void
    {
        $this->Authorization->skipAuthorization();

        if ($id === null) {
            $siape = $this->getRequest()->getQuery('siape');
            if ($siape) {
                $query = $this->Professores->find()
                    ->where(['siape' => $siape])
                    ->first();
                $id = $query?->id ? (string)$query->id : null;
            }
        }

        if ($id === null) {
            $this->Flash->error(__('Não há registros de professor para esse identificador!'));
            $this->redirect(['action' => 'index']);

            return;
        }

        $professor = $this->Professores->get($id, contain: ['Monografias']);
        $this->set(compact('professor'));
    }

    public function add(): ?Response
    {
        $professor = $this->Professores->newEmptyEntity();
        $professor->status = 'ativo';

        $siape = $this->getRequest()->getQuery('siape');
        $email = $this->getRequest()->getQuery('email');
        if ($siape) {
            $professor->siape = $siape;
        }
        if ($email) {
            $professor->email = $email;
        }

        $this->Authorization->authorize($professor, 'add');

        if ($this->request->is('post')) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('O professor foi salvo com sucesso.'));

                return $this->redirect(['action' => 'view', $professor->id]);
            }
            $this->Flash->error(__('Não foi possível salvar o professor. Tente novamente.'));
        }
        $this->set(compact('professor'));

        return null;
    }

    public function edit(?string $id = null): ?Response
    {
        $professor = $this->Professores->get($id, contain: []);
        $professor->status = $this->canonicalStatus((string)$professor->status);
        $this->Authorization->authorize($professor, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('O professor foi atualizado com sucesso.'));

                return $this->redirect(['action' => 'view', $professor->id]);
            }
            $this->Flash->error(__('Não foi possível atualizar o professor. Tente novamente.'));
        }
        $this->set(compact('professor'));

        return null;
    }

    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $professor = $this->Professores->get($id);
        $this->Authorization->authorize($professor, 'delete');

        if ($this->Professores->delete($professor)) {
            $this->Flash->success(__('O professor foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o professor. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function buscaprofessor(): void
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->getRequest()->getData('nome');
        if ($nome) {
            $query = $this->Professores->find()
                ->where(['nome LIKE' => "%{$nome}%"])
                ->orderBy(['nome' => 'ASC']);
            $professores = $this->paginate($query);
            $departamentosList = [];
            $statusList = [];
            $statusFilter = null;
            $statusFilterLabel = null;
            $departamentoFilter = null;

            $this->set(compact(
                'professores',
                'departamentosList',
                'statusList',
                'statusFilter',
                'statusFilterLabel',
                'departamentoFilter',
            ));
            $this->render('index');
        } else {
            $this->Flash->error(__('Digite um nome para buscar.'));
            $this->redirect(['action' => 'index']);
        }
    }

    private function canonicalStatus(string $status): string
    {
        foreach (self::STATUS_ALIASES as $canonicalStatus => $aliases) {
            if (in_array($status, $aliases, true)) {
                return $canonicalStatus;
            }
        }

        return $status;
    }
}
