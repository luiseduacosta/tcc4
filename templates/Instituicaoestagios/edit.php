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
        <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?=
        $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $instituicaoestagio->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicaoestagio->id), 'class' => 'btn btn-danger float-right']
        )
        ?>
    </div>

    <div class="column-responsive column-80">
        <div class="instituicaoestagios form content">
            <?= $this->Form->create($instituicaoestagio) ?>
            <fieldset>
                <legend><?= __('Editar instituição') ?></legend>
                <?php
                echo $this->Form->control('instituicao');
                echo $this->Form->control('areainstituicoes_id', ['options' => $areainstituicoes, 'empty' => true]);
                echo $this->Form->control('area');
                echo $this->Form->control('natureza');
                echo $this->Form->control('cnpj');
                echo $this->Form->control('email');
                echo $this->Form->control('url');
                echo $this->Form->control('endereco');
                echo $this->Form->control('bairro');
                echo $this->Form->control('municipio');
                echo $this->Form->control('cep');
                echo $this->Form->control('telefone');
                echo $this->Form->control('fax');
                echo $this->Form->control('beneficio');
                echo $this->Form->control('fim_de_semana');
                echo $this->Form->control('localInscricao');
                echo $this->Form->control('convenio');
                echo $this->Form->control('expira', ['empty' => true]);
                echo $this->Form->control('seguro');
                echo $this->Form->control('avaliacao');
                echo $this->Form->control('observacoes');
                echo $this->Form->control('supervisores._ids', ['options' => $supervisores]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
