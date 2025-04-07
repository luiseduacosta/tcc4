<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotccs);
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class='nav-item'>
                <?= $this->Html->link(__('Novo Agendamento de Tcc'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        </ul>
    </div>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Agendamento de Oficina de TCC') ?></h3>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('Alunos.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('Professores.nome', 'Orientador') ?></th>
                <th><?= $this->Paginator->sort('Professores1.nome', 'Banca 1') ?></th>
                <th><?= $this->Paginator->sort('Professores2.nome', 'Banca 2') ?></th>
                <th><?= $this->Paginator->sort('data') ?></th>
                <th><?= $this->Paginator->sort('horario') ?></th>
                <th><?= $this->Paginator->sort('sala') ?></th>
                <th><?= $this->Paginator->sort('titulo') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                <?php // pr($agendamentotcc->aluno) ?>
                <tr>
                    <td><?= $agendamentotcc->hasValue('aluno') ? $this->Html->link($agendamentotcc->aluno['nome'], ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->aluno['id']]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('professor') ? $this->Html->link($agendamentotcc->professor['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professor['id']]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('professorbanca1') ? $this->Html->link($agendamentotcc->professorbanca1['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professorbanca1['id']]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('professorbanca2') ? $this->Html->link($agendamentotcc->professorbanca2['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professorbanca2['id']]) : '' ?>
                    </td>
                    <td><?= h($agendamentotcc->data) ?></td>
                    <td><?= h($agendamentotcc->horario) ?></td>
                    <td><?= h($agendamentotcc->sala) ?></td>
                    <td><?= h($agendamentotcc->titulo) ?></td>
                    <td><?= h($agendamentotcc->avaliacao) ?></td>
                    <td class="row">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $agendamentotcc->id]) ?>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['
                            action' => 'delete',
                                $agendamentotcc->id
                            ], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $agendamentotcc->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
        </p>
    </div>
</div>