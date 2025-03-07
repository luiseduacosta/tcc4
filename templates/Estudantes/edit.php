<?php
$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstudantesEdit"
        aria-controls="navbarTogglerEstudantesEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstudantesEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estudante->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estudante->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <div class="alunos form content">
        <?= $this->Form->create($estudante) ?>
        <fieldset>
            <legend><?= __('Editar estudante') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('registro');
            echo $this->Form->control('codigo_telefone');
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_celular');
            echo $this->Form->control('celular');
            echo $this->Form->control('email');
            echo $this->Form->control('cpf');
            echo $this->Form->control('identidade');
            echo $this->Form->control('orgao');
            echo $this->Form->control('nascimento', ['empty' => true]);
            echo $this->Form->control('endereco');
            echo $this->Form->control('cep');
            echo $this->Form->control('municipio');
            echo $this->Form->control('bairro');
            echo $this->Form->control('observacoes');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirmar')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>