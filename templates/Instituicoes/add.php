<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerInstituicoes"
        aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerInstituicoes">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($instituicaoestagio) ?>
    <fieldset>
        <legend><?= __('Nova instituição') ?></legend>
        <?php
        echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição'], 'required' => true]);
        echo $this->Form->control('areainstituicoes_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areainstituicoes, 'empty' => true]);
        echo $this->Form->control('natureza', ['label' => ['text' => 'Natureza']]);
        echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ'], 'placeholder' => '00.000.000/0000-00', 'required' => true]);
        echo $this->Form->control('email');
        echo $this->Form->control('url', ['label' => ['text' => 'Site']]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
        echo $this->Form->control('bairro');
        echo $this->Form->control('municipio');
        echo $this->Form->control('cep');
        echo $this->Form->control('telefone');
        echo $this->Form->control('fax', ['type' => 'hidden']);
        echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios']]);
        echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
        echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local de inscrição'], 'placeholder' => 'Local de inscrição', 'required' => false]);
        echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'placeholder' => 'Número do convêncio registrado na PR4', 'required' => true]);
        echo $this->Form->control('expira', ['placeholder' => 'Data de encerramento do convênio', 'empty' => true]);
        echo $this->Form->control('seguro', ['label' => ['text' => 'Seguro'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'required' => true]);
        echo $this->Form->control('avaliacao', ['type' => 'hidden']);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
        echo $this->Form->control('supervisores._ids', ['options' => $supervisores, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>