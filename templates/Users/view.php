<?php
$usuario = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($usuario->role) && $usuario->role == 'admin'): ?>
            <li><?= $this->Html->link(__('Novo usuário'), ['action' => 'add']) ?> </li>        
            <li><?= $this->Html->link(__('Editar usuário'), ['action' => 'edit', $user->id]) ?> </li>
            <li><?= $this->Form->postLink(__('Excluir usuaŕio'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que quer excluir # {0}?', $user->id)]) ?> </li>
        <?php endif; ?>
        <li><?= $this->Html->link(__('Listar usuarios'), ['action' => 'index']) ?> </li>

    </ul>
</nav>
<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($user->id) ?></h3>
    <table class="table table-striped table-hover">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Categoria') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
</div>
