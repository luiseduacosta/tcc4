<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<div class="users form container">
    <?php echo $this->element('menu_mural') ?>
    <?= $this->Flash->render() ?>
    <h3>Login</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Digite seu usuário e senha') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['label' => ['text' => 'Senha'], 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Login')); ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link("Cadastrar novo usuário", ['action' => 'add']) ?>
    <?= $this->Html->link("Esqueceu a senha?", ['action' => 'add']) ?>
</div>