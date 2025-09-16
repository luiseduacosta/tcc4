<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\User $user
 */
?>

<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        if ($('#codigo-telefone').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-telefone').val();
        }
        if ($('#telefone').val().length == 9) {
            $('#telefone').val('(' + codigo + ') ' + $('#telefone').val());
        } else {
            $('#telefone').mask('(00) 0000-0000');
        }
        if ($('#codigo-celular').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-celular').val();
        }
        if ($('#celular').val().length == 10) {
            $('#celular').val('(' + codigo + ') ' + $('#celular').val());
        } else {
            $('#celular').mask('(00) 00000-0000');
        }
        $('#nascimento').mask('00/00/0000');
        $('#cep').mask('00000-000');
        $('#ingresso').mask('0000-0');
        $('#novoperiodo').val($('#ingresso').val());
        $('#novoperiodo').mask('0000-0');
    });
</script>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunosEdit"
        aria-controls="navbarTogglerAlunosEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAlunosEdit">
        <?php if (isset($user->categoria) && $user->categoria == "1"): ?>
            <?= $this->Html->link(
                __("Listar Alunos"),
                ["action" => "index"],
                ["class" => "btn btn-primary me-1"],
            ) ?>
            <?= $this->Form->postLink(
                __("Excluir"),
                ["action" => "delete", $aluno->id],
                [
                    "confirm" => __(
                        "Tem certeza que deseja excluir este registo # {0}?",
                        $aluno->id,
                    ),
                    "class" => "btn btn-danger me-1",
                ],
            ) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __("Editar aluno(a)") ?></legend>
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
            "label" => "Data de nascimento",
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
            "label" => "Orgão emissor",
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
            __("Confirmar alterações"), ["class" => "btn btn-primary"],
        ) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
