<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao[]|\Cake\Collection\CollectionInterface $areainstituicoes
 */
?>
<div class="areainstituicoes index content">
    <?= $this->Html->link(__('New Areainstituicao'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Areainstituicoes') ?></h3>
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
                <?php foreach ($areainstituicoes as $areainstituicao): ?>
                <tr>
                    <td><?= $this->Number->format($areainstituicao->id) ?></td>
                    <td><?= h($areainstituicao->area) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $areainstituicao->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $areainstituicao->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $areainstituicao->id)]) ?>
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
