<?php
$usuario = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('templates') ?>

<div class="users form">
    <?= $this->Flash->render() ?>
    <!--
    <h3>Login</h3>
    -->
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Por favor informe seu usuário e senha') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>
