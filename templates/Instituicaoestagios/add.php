<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
?>
<div class='container'>
    <div class="row justify-content-center">
        <?php echo $this->element('menu_mural') ?>
    </div>
    <div class="row">
        <?= $this->Html->link(__('Listar instituições de estágio'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="column-responsive column-80">
        <div class="instituicaoestagios form content">
            <?= $this->Form->create($instituicaoestagio) ?>
            <fieldset>
                <legend><?= __('Nova instituição de estágio') ?></legend>
                <?php
                echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição']]);
                echo $this->Form->control('areainstituicoes_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areainstituicoes, 'empty' => true]);
                echo $this->Form->control('area', ['label' => ['text' => 'Área']]);
                echo $this->Form->control('natureza', ['label' => ['text' => 'Natureza']]);
                echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ']]);
                echo $this->Form->control('email');
                echo $this->Form->control('url');
                echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
                echo $this->Form->control('bairro');
                echo $this->Form->control('municipio');
                echo $this->Form->control('cep');
                echo $this->Form->control('telefone');
                echo $this->Form->control('fax', ['type' => 'hidden']);
                echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios']]);
                echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?']]);
                echo $this->Form->control('localInscricao');
                echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio']]);
                echo $this->Form->control('expira', ['empty' => true]);
                echo $this->Form->control('seguro');
                echo $this->Form->control('avaliacao', ['type' => 'hidden']);
                echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
                echo $this->Form->control('supervisores._ids', ['options' => $supervisores, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>