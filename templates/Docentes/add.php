<?php

$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<?= $this->element('templates') ?>

<div class="row">
    <?= $this->Form->create($docente) ?>
    <fieldset>
        <legend><?= __('Novo(a) docente') ?></legend>
        <?php
        echo $this->Form->control('nome', ['label' => 'Nome completo', 'required' => true]);
        echo $this->Form->control('cpf', ['label' => 'CPF', 'required' => true]);
        echo $this->Form->control('siape', ['label' => 'SIAPE', 'required' => true]);
        echo $this->Form->control('rg', ['label' => 'RG',  'required' => true]);
        echo $this->Form->control('orgaoexpedidor', ['label' => 'Órgão expedidor', 'required' => true]);
        echo $this->Form->control('datanascimento', ['label' => 'Data de nascimento']);
        echo $this->Form->control('localnascimento', ['label' => 'Local de nascimento']);
        echo $this->Form->control('datanascimento', ['label' => 'Data de nascimento', 'empty' => true]);
        echo $this->Form->control('localnascimento', ['label' => 'Local de nascimento']);
        echo $this->Form->control('sexo', ['options' => ['1' => 'Homem', '2' => 'Mulher'], 'label' => 'Sexo', 'empty' => true]);
        echo $this->Form->control('ddd_telefone', ['label' => 'DDD telefone']);
        echo $this->Form->control('telefone', ['label' => 'Telefone']);
        echo $this->Form->control('ddd_celular', ['label' => 'DDD celular']);
        echo $this->Form->control('celular', ['label' => 'Celular', 'required' => true]);
        echo $this->Form->control('email', ['label' => 'E-mail', 'required' => true]);
        echo $this->Form->control('homepage', ['label' => 'Homepage']);
        echo $this->Form->control('redesocial', ['label' => 'Rede social']);
        echo $this->Form->control('curriculolattes', ['label' => 'Currículo Lattes']);
        echo $this->Form->control('atualizacaolattes', ['label' => 'Atualização Lattes', 'empty' => true]);
        echo $this->Form->control('curriculosigma', ['label' => 'Currículo Sigma']);
        echo $this->Form->control('pesquisadordgp', ['label' => 'Pesquisador DGP']);
        echo $this->Form->control('endereco', ['label' => 'Endereço']);
        echo $this->Form->control('bairro', ['label' => 'Bairro']);
        echo $this->Form->control('cidade', ['label' => 'Cidade']);
        echo $this->Form->control('estado', ['label' => 'Estado']);
        echo $this->Form->control('cep', ['label' => 'CEP']);
        echo $this->Form->control('pais', ['label' => 'País']);
        echo $this->Form->control('formacaoprofissional', ['label' => 'Formação profissional']);
        echo $this->Form->control('graduacaoarea', ['label' => 'Área de graduação']);
        echo $this->Form->control('universidadedegraduacao', ['label' => 'Universidade de graduação']);
        echo $this->Form->control('anoformacao', ['label' => 'Ano de formação']);
        echo $this->Form->control('mestradoarea', ['label' => 'Área de mestrado']);
        echo $this->Form->control('mestradouniversidade', ['label' => 'Universidade de mestrado']);
        echo $this->Form->control('mestradoanoconclusao', ['label' => 'Ano de conclusão do mestrado']);
        echo $this->Form->control('doutoradoarea', ['label' => 'Área de doutorado']);
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
        echo $this->Form->control('regimetrabalho', ['label' => 'Regime de trabalho', 'options' => ['20' => '20', '40' => '40', 'DE' => 'DE']]);
        echo $this->Form->control('departamento', ['options' => ['label' => 'Departamento' ,'Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['label' => 'Data de egresso', 'empty' => true]);
        echo $this->Form->control('motivoegresso', ['label' => 'Motivo de egresso', 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        echo $this->Form->control('observacoes', ['label' => 'Observações']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>