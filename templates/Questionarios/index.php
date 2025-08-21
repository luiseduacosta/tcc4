<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Questionario> $questionarios
 */
?>
<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <?= $this->Html->link(__('Novo Questionario'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<h3><?= __('Questionarios') ?></h3>

<div class="container mt-4">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('title', 'Título') ?></th>
                <th><?= $this->Paginator->sort('created', 'Criado') ?></th>
                <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                <th><?= $this->Paginator->sort('is_active', 'Activo') ?></th>
                <th><?= $this->Paginator->sort('category', 'Categoria') ?></th>
                <th><?= $this->Paginator->sort('target_user_type', 'Tipo de usuário alvo') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questionarios as $questionario): ?>
                <tr>
                    <td><?= $this->Number->format($questionario->id) ?></td>
                    <td><?= h($questionario->title) ?></td>
                    <td><?= h($questionario->created) ?></td>
                    <td><?= h($questionario->modified) ?></td>
                    <td><?= h($questionario->is_active) ?></td>
                    <td><?= h($questionario->category) ?></td>
                    <td><?= h($questionario->target_user_type) ?></td>
                    <td class="table-info">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $questionario->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questionario->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questionario->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questionario->id)]) ?>
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
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>
