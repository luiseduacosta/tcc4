<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($estudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo estudante'), ['action' => 'add']) ?></li>
        <?php endif; ?>
        <?= $this->element('menu_monografias') ?>
    </ul>
</nav>
<div class="tccestudantes index large-9 medium-8 columns content">
    <h3><?= __('Estudantes') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('nome', ['label' => 'Busca por nome', 'value' => $this->getRequest()->getSession()->read('estudante')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudantes as $estudante): ?>
                <?php // pr($estudante->monografia->); ?>
                <?php // die(); ?>
                <?php if (isset($estudante->monografia->id) && !empty($estudante->monografia->id)): ?>
                    <tr>
                        <td><?= h($estudante->id) ?></td>
                        <td><?= h($estudante->registro) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->nome)), ['action' => 'view', $estudante->id]) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->monografia->titulo)), ['controller' => 'monografias', 'action' => 'view', $estudante->monografia->id]) ?></td>
                        <td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= h($estudante->id) ?></td>
                        <td><?= h($estudante->registro) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->nome)), ['action' => 'view', $estudante->id]) ?></td>

                        <td>Estudante sem monografia?</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>

    </div>

</div>
