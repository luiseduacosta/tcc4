<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?></div>

<?= $this->element('templates') ?>

<div class="container col-lg-5 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($user, ['template' => ['formStart' => '<form{{attrs}}>', 'formEnd' => '</form>']]) ?>
    <fieldset class="border p-3 mb-4">
        <legend class="h5"><?= __('Por favor informe seu usuário e senha') ?></legend>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Usuário</label>
            <div class="col-sm-10">
                <?= $this->Form->control('email', ['required' => true, 'label' => false, 'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Senha</label>
            <div class="col-sm-10">
                <?= $this->Form->control('password', ['required' => true, 'label' => false, 'class' => 'form-control']) ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Login'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>