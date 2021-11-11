<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio[]|\Cake\Collection\CollectionInterface $areaestagios
 */
?>
<div class="areaestagios index content">
    <?= $this->Html->link(__('New Areaestagio'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Areaestagios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areaestagios as $areaestagio): ?>
                <tr>
                    <td><?= $this->Number->format($areaestagio->id) ?></td>
                    <td><?= h($areaestagio->area) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $areaestagio->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $areaestagio->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $areaestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $areaestagio->id)]) ?>
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
