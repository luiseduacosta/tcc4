<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>

<div class="row justify-content-center">
    <?= $this->element('menu_mural') ?>
</div>

<div class="docentes index content container">
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('siape') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                    <th><?= $this->Paginator->sort('departamento') ?></th>
                    <th><?= $this->Paginator->sort('dataegresso', 'Egresso') ?></th>
                    <th><?= $this->Paginator->sort('motivoegresso', 'Motivo') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docentes as $docente): ?>
                    <tr>
                        <td><?= $docente->id ?></td>
                        <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?></td>
                        <td><?= $docente->siape ?></td>
                        <td><?= h($docente->email) ?></td>
                        <td><?= $docente->curriculolattes ? $this->Html->link($docente->curriculolattes, 'http://lattes.cnpq.br/' . $docente->curriculolattes) : '' ?></td>
                        <td><?= h($docente->departamento) ?></td>
                        <td><?= $docente->dataegresso ? date('d-m-Y', strtotime(h($docente->dataegresso))) : '' ?></td>
                        <td><?= h($docente->motivoegresso) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $docente->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $docente->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $docente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $docente->id)]) ?>
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
