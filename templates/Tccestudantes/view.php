<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($tccestudante);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $tccestudante->id]) ?> </li>
            <li><?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $tccestudante->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $tccestudante->id)]) ?> </li>
        <?php endif; ?>
        <?= $this->element('menu_monografias') ?>
    </ul>
</nav>
<div class="tccestudantes view large-9 medium-8 columns content">
    <h3><?= h($tccestudante->Nome) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($tccestudante->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro') ?></th>
            <td><?= h($tccestudante->registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($tccestudante->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monografia') ?></th>
            <td><?= $this->Html->link($tccestudante->monografia->titulo, ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografia->id]) ?></td>
        </tr>
    </table>
</div>
