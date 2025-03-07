<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao[]|\Cake\Collection\CollectionInterface $areainstituicoes
 */
?>
<div class="areainstituicoes index content">
    <?php echo $this->element('menu_mural') ?>
    <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Área instituicoes') ?></h3>
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
                        <td><?= $areainstituicao->id ?></td>
                        <td><?= h($areainstituicao->area) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $areainstituicao->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $areainstituicao->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
