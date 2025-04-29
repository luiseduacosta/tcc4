<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita[]|\Cake\Collection\CollectionInterface $visitas
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>

<h3><?= __('Visitas instituicionais') ?></h3>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('instituicaoestagio_id', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('data', 'Data') ?></th>
                <th><?= $this->Paginator->sort('motivo', 'Motivo') ?></th>
                <th><?= $this->Paginator->sort('responsavel', 'Responsável') ?></th>
                <th><?= $this->Paginator->sort('avaliacao', 'Avaliação') ?></th>
                <th class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?= $visita->id ?></td>
                    <td><?= $visita->has('instituicaoestagio') ? $this->Html->link($visita->instituicaoestagio->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicaoestagio->id]) : '' ?></td>
                    <td><?= date('d-m-Y', strtotime(h($visita->data))) ?></td>
                    <td><?= h($visita->motivo) ?></td>
                    <td><?= h($visita->responsavel) ?></td>
                    <td><?= h($visita->avaliacao) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Visitas', 'action' => 'view', $visita->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Visitas', 'action' => 'edit', $visita->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Visitas', 'action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visita->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
    </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?></p>
    </div>
</div>
