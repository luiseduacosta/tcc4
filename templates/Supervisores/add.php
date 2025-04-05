<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerSupervisores"
            aria-controls="navbarTogglerSupervisores" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerSupervisores">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar supervisores'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($supervisor) ?>
    <fieldset>
        <legend><?= __('Nova supervisora') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('cpf');
        echo $this->Form->control('endereco');
        echo $this->Form->control('bairro');
        echo $this->Form->control('municipio');
        echo $this->Form->control('cep');
        echo $this->Form->control('codigo_tel');
        echo $this->Form->control('telefone');
        echo $this->Form->control('codigo_cel');
        echo $this->Form->control('celular');
        echo $this->Form->control('email');
        echo $this->Form->control('escola');
        echo $this->Form->control('ano_formatura');
        echo $this->Form->control('cress');
        echo $this->Form->control('regiao');
        echo $this->Form->control('outros_estudos');
        echo $this->Form->control('area_curso');
        echo $this->Form->control('ano_curso');
        echo $this->Form->control('cargo');
        echo $this->Form->control('num_inscricao');
        echo $this->Form->control('curso_turma');
        echo $this->Form->control('observacoes');
        echo $this->Form->control('instituicaoestagios._ids', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>