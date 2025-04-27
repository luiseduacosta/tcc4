<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
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
        echo $this->Form->control('nome', ['label' => ['text' => 'Nome'], 'type' => 'text']);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'type' => 'text', 'mask' => '000.000.000-00', 'placeholder' => '000.000.000-00']);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço'], 'type' => 'text', 'placeholder' => 'Endereço']);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro'], 'type' => 'text', 'placeholder' => 'Bairro']);
        echo $this->Form->control('municipio', ['label' => ['text' => 'Município'], 'type' => 'text', 'placeholder' => 'Município']);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'type' => 'text', 'mask' => '00000-000', 'placeholder' => '00000-000']);
        echo $this->Form->control('codigo_tel', ['label' => ['text' => 'DDD'], 'type' => 'number']);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone'], 'type' => 'text', 'mask' => '(00) 0000-0000', 'placeholder' => '(00) 0000-0000']);
        echo $this->Form->control('codigo_cel', ['label' => ['text' => 'DDD'], 'type' => 'number']);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular'], 'type' => 'text', 'mask' => '(00) 00000-0000', 'placeholder' => '(00) 00000-0000']);
        echo $this->Form->control('email', ['label' => ['text' => 'E-mail'], 'type' => 'email']);
        echo $this->Form->control('escola', ['label' => ['text' => 'Escola de origem'], 'type' => 'text']);
        echo $this->Form->control('ano_formatura', ['label' => ['text' => 'Ano de formatura'], 'type' => 'number', 'mask' => '0000', 'placeholder' => '0000']);
        echo $this->Form->control('cress', ['label' => ['text' => 'Cress'], 'type' => 'number']);
        echo $this->Form->control('regiao', ['label' => ['text' => 'Região'], 'type' => 'number']);
        echo $this->Form->control('outros_estudos', ['label' => ['text' => 'Outros estudos'], 'type' => 'text']);
        echo $this->Form->control('area_curso', ['label' => ['text' => 'Área do curso'], 'type' => 'text']);
        echo $this->Form->control('ano_curso', ['label' => ['text' => 'Ano do curso'], 'type' => 'number', 'mask' => '0000', 'placeholder' => '0000']);
        echo $this->Form->control('cargo', ['label' => ['text' => 'Cargo'], 'type' => 'text']);
        echo $this->Form->control('num_inscricao', ['label' => ['text' => 'Número de inscrição para o curso de supervisores'], 'type' => 'number']);
        echo $this->Form->control('curso_turma', ['label' => ['text' => 'Turma do curso de supervisores'], 'type' => 'number']);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'type' => 'textarea']);
        echo $this->Form->control('instituicaoestagios._ids', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Salvar', ['class' => 'btn btn-primary'])) ?>
    <?= $this->Form->end() ?>
</div>