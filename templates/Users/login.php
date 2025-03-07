<?php
$usuario = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
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