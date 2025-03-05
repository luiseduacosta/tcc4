<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
// pr($agendamentotccs);
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAgendamentos"
        aria-controls="navbarTogglerAgendamentos" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerAgendamentos">
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerDocentes">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li>
                    <?= $this->Html->link(__('Novo Agendamento de Tcc'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<h3><?= __('Agendamento de Oficina de TCC') ?></h3>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('Docentes.nome', 'Orientador') ?></th>
                <th><?= $this->Paginator->sort('Docentes1.nome', 'Banca 1') ?></th>
                <th><?= $this->Paginator->sort('Docentes2.nome', 'Banca 2') ?></th>
                <th><?= $this->Paginator->sort('data') ?></th>
                <th><?= $this->Paginator->sort('horario') ?></th>
                <th><?= $this->Paginator->sort('sala') ?></th>
                <th><?= $this->Paginator->sort('titulo') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                <tr>
                    <td><?= $agendamentotcc->has('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Agendamentotccs', 'action' => 'view', $agendamentotcc->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('docentes1') ? $this->Html->link($agendamentotcc->docentes1->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes1->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('docentes2') ? $this->Html->link($agendamentotcc->docentes2->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes2->id]) : '' ?>
                    </td>
                    <td><?= h($agendamentotcc->data) ?></td>
                    <td><?= h($agendamentotcc->horario) ?></td>
                    <td><?= h($agendamentotcc->sala) ?></td>
                    <td><?= h($agendamentotcc->titulo) ?></td>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td><?= h($agendamentotcc->avaliacao) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $agendamentotcc->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $agendamentotcc->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['
                            action' => 'delete', $agendamentotcc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agendamentotcc->id)]) ?>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates') ?>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>
