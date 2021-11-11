<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao[]|\Cake\Collection\CollectionInterface $configuracao
 */
?>
<div class="configuracao index content">
    <?= $this->Html->link(__('New Configuracao'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Configuracao') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('mural_periodo_atual', 'Período do mural') ?></th>
                    <th><?= $this->Paginator->sort('termo_compromisso_periodo', 'Período do termo de compromisso') ?></th>
                    <th><?= $this->Paginator->sort('termo_compromisso_inicio', 'Data de início do termo de compromisso') ?></th>
                    <th><?= $this->Paginator->sort('termo_compromisso_final', 'Data de finalização do termo de compromisso') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($configuracao as $configuracao): ?>
                <tr>
                    <td><?= $configuracao->id ?></td>
                    <td><?= h($configuracao->mural_periodo_atual) ?></td>
                    <td><?= h($configuracao->termo_compromisso_periodo) ?></td>
                    <td><?= h($configuracao->termo_compromisso_inicio) ?></td>
                    <td><?= h($configuracao->termo_compromisso_final) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $configuracao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $configuracao->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $configuracao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $configuracao->id)]) ?>
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
