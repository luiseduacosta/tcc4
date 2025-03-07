<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio[]|\Cake\Collection\CollectionInterface $areaestagios
 */
?>

<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<div class="d-flex justify-content-start">
<?= $this->Html->link(__('Nova área de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
</div>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Áreas de estágios') ?></h3>
    <table class="table table-responsive table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('area') ?></th>
                <th class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areaestagios as $areaestagio): ?>
                <tr>
                    <td><?= $areaestagio->id ?></td>
                    <td><?= h($areaestagio->area) ?></td>
                    <td class="row">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $areaestagio->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $areaestagio->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $areaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areaestagio->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>