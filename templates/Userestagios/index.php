<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio[]|\Cake\Collection\CollectionInterface $userestagios
 */
?>
<div class="userestagios index container">
    <?php echo $this->element('menu_mural') ?>
    <?= $this->Html->link(__('Novo usuário de estágio'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Usuário de estágios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria') ?></th>
                    <th><?= $this->Paginator->sort('numero') ?></th>
                    <th><?= $this->Paginator->sort('estudante_id') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_id') ?></th>
                    <th><?= $this->Paginator->sort('docente_id') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userestagios as $userestagio): ?>
                    <tr>
                        <td><?= $userestagio->id ?></td>
                        <td><?= h($userestagio->email) ?></td>
                        <td><?= h($userestagio->categoria) ?></td>
                        <td><?= $userestagio->numero ?></td>
                        <td><?= $userestagio->has('estudante') ? $this->Html->link($userestagio->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $userestagio->estudante->id]) : '' ?></td>
                        <td><?= $userestagio->has('supervisor') ? $this->Html->link($userestagio->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?></td>
                        <td><?= $userestagio->has('docente') ? $this->Html->link($userestagio->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $userestagio->docente->id]) : '' ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $userestagio->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userestagio->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagio->id)]) ?>
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
