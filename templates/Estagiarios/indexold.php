<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiarios);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <ul class="side-nav">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo Estagiário'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="collapse navbar-collapse list-unstyled" id="navbarTogglerAreamonografia">
    <h3><?= __('Estagiarios') ?></h3>
    <table class="table table-hover table-responsive table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tccestudante.nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('turno') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monografia_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $estagiario): ?>
                <?php // pr($estagiario->tccestudante->id) ?>
                <tr>
                    <td><?= $this->Number->format($estagiario->id) ?></td>
                    <td><?= $this->Html->link($estagiario->tccestudante->nome, ['controller' => 'Tccestudantes', 'action' => 'view', $estagiario->tccestudante->id]) ?>
                    </td>
                    <td><?= h($estagiario->registro) ?></td>
                    <td><?= h($estagiario->turno) ?></td>
                    <td><?= h($estagiario->nivel) ?></td>
                    <td><?= h($estagiario->periodo) ?></td>
                    <td><?= h($estagiario->tccestudante->monografia_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $estagiario->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estagiario->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element("templates") ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?>
            </p>
        </div>
    </div>
</div>