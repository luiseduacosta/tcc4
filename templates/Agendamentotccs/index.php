<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
// pr($agendamentotccs);
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <?= $this->Html->link(__('Novo agendamento de TCC'), ['action' => 'add'], ['class' => 'button float-right']) ?>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>

<div class="agendamentotccs index content container">
    <h3><?= __('Oficinas de TCC') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
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
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                    <tr>
                        <td><?= $agendamentotcc->has('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Agendamentotccs', 'action' => 'view', $agendamentotcc->id]) : '' ?></td>
                        <td><?= $agendamentotcc->has('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?></td>
                        <td><?= $agendamentotcc->has('docentes1') ? $this->Html->link($agendamentotcc->docentes1->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes1->id]) : '' ?></td>
                        <td><?= $agendamentotcc->has('docentes2') ? $this->Html->link($agendamentotcc->docentes2->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes2->id]) : '' ?></td>'
                        <td><?= h($agendamentotcc->data->format('d-m-Y')) ?></td>
                        <td><?= h($agendamentotcc->horario->i18nFormat('HH:mm:ss')) ?></td>
                        <td><?= $this->Number->format($agendamentotcc->sala) ?></td>
                        <td><?= h($agendamentotcc->titulo) ?></td>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <td><?= h($agendamentotcc->avaliacao) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $agendamentotcc->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $agendamentotcc->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agendamentotcc->id)]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
