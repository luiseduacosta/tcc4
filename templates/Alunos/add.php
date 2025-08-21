<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\User $user
 */
// $user = $this->getRequest()->getAttribute('identity');
// pr($registro);
// die();
?>

<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 0000.0000');
        $('#celular').mask('(00) 00000.0000');
        $('#cep').mask('00000-000');
    });
</script>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunosAdd"
        aria-controls="navbarTogglerAlunosAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAlunosAdd">
        <?php if (isset($user->categoria) && $user->categoria == "1"): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Listar alunos"),
                    ["action" => "index"],
                    ["class" => "btn btn-primary"],
                ) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __("Novo aluno") ?></legend>
        <?php
        echo $this->Form->control("nome", [
            "label" => "Nome",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nomesocial", [
            "label" => "Nome social",
            "class" => "form-control",
        ]);
        echo $this->Form->control("registro", [
            "label" => "Registro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("ingresso", [
            "label" => "Ingresso",
            "class" => "form-control",
        ]);
        echo $this->Form->control("turno", [
            "label" => "Turno",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nascimento", [
            "empty" => true,
            "class" => "form-control",
        ]);
        echo $this->Form->control("cpf", [
            "label" => "CPF",
            "class" => "form-control",
        ]);
        echo $this->Form->control("identidade", [
            "label" => "RG",
            "class" => "form-control",
        ]);
        echo $this->Form->control("orgao", [
            "label" => "Orgão",
            "class" => "form-control",
        ]);
        echo $this->Form->control("email", [
            "label" => "E-mail",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_telefone", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("telefone", [
            "label" => "Telefone",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_celular", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("celular", [
            "label" => "Celular",
            "class" => "form-control",
        ]);
        echo $this->Form->control("cep", [
            "label" => "CEP",
            "class" => "form-control",
        ]);
        echo $this->Form->control("endereco", [
            "label" => "Endereço",
            "class" => "form-control",
        ]);
        echo $this->Form->control("municipio", [
            "label" => "Município",
            "class" => "form-control",
        ]);
        echo $this->Form->control("bairro", [
            "label" => "Bairro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("observacoes", [
            "label" => "Observações",
            "class" => "form-control",
        ]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(
            __("Confirma", ["class" => "btn btn-primary mt-1"]),
        ) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
