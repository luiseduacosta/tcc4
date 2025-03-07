<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
// pr($registro);
// die();
?>
<div class="row justify-content-center">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAlunosAdd"
        aria-controls="navbarTogglerAlunosAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAlunosAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar alunos'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __('Novo aluno') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('registro');
        echo $this->Form->control('nascimento', ['empty' => true]);
        echo $this->Form->control('cpf');
        echo $this->Form->control('identidade');
        echo $this->Form->control('orgao');
        echo $this->Form->control('email');
        echo $this->Form->control('codigo_telefone');
        echo $this->Form->control('telefone');
        echo $this->Form->control('codigo_celular');
        echo $this->Form->control('celular');
        echo $this->Form->control('cep');
        echo $this->Form->control('endereco');
        echo $this->Form->control('municipio');
        echo $this->Form->control('bairro');
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>