<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita[]|\Cake\Collection\CollectionInterface $visitas
 */
?>
<div class="visitas index content">
    <?= $this->Html->link(__('New Visita'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Visitas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicaoestagio_id') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('motivo') ?></th>
                    <th><?= $this->Paginator->sort('responsavel') ?></th>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?= $this->Number->format($visita->id) ?></td>
                    <td><?= $visita->has('instituicaoestagio') ? $this->Html->link($visita->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $visita->instituicaoestagio->id]) : '' ?></td>
                    <td><?= date('d-m-Y', strtotime(h($visita->data))) ?></td>
                    <td><?= h($visita->motivo) ?></td>
                    <td><?= h($visita->responsavel) ?></td>
                    <td><?= h($visita->avaliacao) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $visita->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $visita->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $visita->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id)]) ?>
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
