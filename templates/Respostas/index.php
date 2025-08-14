<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resposta> $respostas
 */
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <?= $this->Html->link(__('Nova resposta'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <h3><?= __('Respostas') ?></h3>
    <div class="container mt-4">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('question_id') ?></th>
                    <th><?= $this->Paginator->sort('estagiarios_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respostas as $resposta): ?>
                    <tr>
                        <td><?= $this->Number->format($resposta->id) ?></td>
                        <td><?= $resposta->has('questione') ? $this->Html->link($resposta->questione->type, ['controller' => 'Questiones', 'action' => 'view', $resposta->questione->id]) : '' ?>
                        </td>
                        <td><?= $resposta->has('estagiario') ? $this->Html->link($resposta->estagiario->periodo, ['controller' => 'Estagiarios', 'action' => 'view', $resposta->estagiario->id]) : '' ?>
                        </td>
                        <td><?= h($resposta->created) ?></td>
                        <td><?= h($resposta->modified) ?></td>
                        <td class="table-info">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $resposta->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $resposta->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resposta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resposta->id)]) ?>
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

</div>