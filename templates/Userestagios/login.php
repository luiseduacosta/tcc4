<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

<div class="container">
    <div class="row justify-content-center">
        <?php echo $this->element('menu_mural') ?>   
    </div>
    <div class="row justify-content-center">
        <?= $this->Html->link("Cadastrar novo usuário", ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link("Esqueceu a senha?", ['action' => 'add'], ['class' => 'btn btn-primary']) ?>    
    </div>
    <div class="row justify-content-center">
        <?= $this->Flash->render() ?>
    </div>
    <div class="row justify-content-center">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Digite seu usuário e senha') ?></legend>
            <?= $this->Form->control('email', ['required' => true]) ?>
            <?= $this->Form->control('password', ['label' => ['text' => 'Senha'], 'required' => true]) ?>
        </fieldset>
        <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-success']); ?>
        <?= $this->Form->end() ?>
    </div>
</div>