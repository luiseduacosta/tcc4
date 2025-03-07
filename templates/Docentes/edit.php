<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDocentesEdit"
        aria-controls="navbarTogglerDocentesEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerDocentesEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $docente->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $docente->id), 'class' => 'btn btn-danger float-start'],
                    )
                    ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($docente) ?>
    <fieldset>
        <legend><?= __('Editar Docente') ?></legend>
        <?php
        echo $this->Form->control('nome', ['label' => 'Nome completo']);
        echo $this->Form->control('cpf', ['label' => 'CPF']);
        echo $this->Form->control('rg', ['label' => 'RG']);
        echo $this->Form->control('orgaoexpedidor', ['label' => 'Órgão expedidor']);
        echo $this->Form->control('siape', ['label' => 'SIAPE']);
        echo $this->Form->control('datanascimento', ['label' => 'Data de nascimento' ,'empty' => true]);
        echo $this->Form->control('localnascimento', ['label' => 'Local de nascimento']);
        echo $this->Form->control('sexo', ['options' => ['1' => 'Homem', '2' => 'Mulher'], 'empty' => true]);
        echo $this->Form->control('ddd_telefone', ['label' => 'DDD telefone']);
        echo $this->Form->control('telefone', ['label' => 'Telefone']);
        echo $this->Form->control('ddd_celular', ['label' => 'DDD celular']);
        echo $this->Form->control('celular', ['label' => 'Celular']);
        echo $this->Form->control('email', ['label' => 'E-mail']);
        echo $this->Form->control('homepage', ['label' => 'Homepage']);
        echo $this->Form->control('redesocial', ['label' => 'Rede social']);
        echo $this->Form->control('curriculolattes', ['label' => 'Currículo Lattes']);
        echo $this->Form->control('atualizacaolattes', ['label' => 'Atualização do Lattes', 'empty' => true]);
        echo $this->Form->control('curriculosigma', ['label' => 'Currículo Sigma']);
        echo $this->Form->control('pesquisadordgp', ['label' => 'Pesquisador DGP']);
        echo $this->Form->control('formacaoprofissional', ['label' => 'Formação profissional']);
        echo $this->Form->control('universidadedegraduacao', ['label' => 'Universidade de graduação']);
        echo $this->Form->control('anoformacao', ['label' => 'Ano de formação']);
        echo $this->Form->control('mestradoarea', ['label' => 'Área de mestrado']);
        echo $this->Form->control('mestradouniversidade', ['label' => 'Universidade de mestrado']);
        echo $this->Form->control('mestradoanoconclusao', ['label' => 'Ano de conclusão do mestrado']);
        echo $this->Form->control('doutoradoarea', ['label' => 'Área de doutorado']);
        echo $this->Form->control('doutoradouniversidade', ['label' => 'Universidade de doutorado']);
        echo $this->Form->control('doutoradoanoconclusao', ['label' => 'Ano de conclusão do doutorado']);
        echo $this->Form->control('dataingresso', ['label' => 'Data de ingresso na ESS', 'empty' => true]);
        echo $this->Form->control('formaingresso', ['label' => 'Forma de ingresso']);
        echo $this->Form->control('tipocargo', ['label' => 'Tipo de cargo']);
        echo $this->Form->control('categoria', ['label' => 'Categoria']);
        echo $this->Form->control('regimetrabalho', ['label' => 'Regime de trabalho']);
        echo $this->Form->control('departamento', ['label' => 'Departamento', 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['label' => 'Data de egresso', 'empty' => true]);
        echo $this->Form->control('motivoegresso', ['label' => 'Motivo de egresso', 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        echo $this->Form->control('observacoes', ['label' => 'Observações']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>
