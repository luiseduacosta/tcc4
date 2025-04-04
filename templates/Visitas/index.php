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
                    <td><?= $visita->id ?></td>
                    <td><?= $visita->has('instituicaoestagio') ? $this->Html->link($visita->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $visita->instituicaoestagio->id]) : '' ?></td>
                    <td><?= date('d-m-Y', strtotime(h($visita->data))) ?></td>
                    <td><?= h($visita->motivo) ?></td>
                    <td><?= h($visita->responsavel) ?></td>
                    <td><?= h($visita->avaliacao) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $visita->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $visita->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visita->id)]) ?>
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
    <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?></p>
</div>
