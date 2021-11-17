<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
?>
<div class='container'>
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $instituicaoestagio->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagio->id), 'class' => 'side-nav-item']
                )
                ?>
                <?= $this->Html->link(__('List Instituicaoestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="instituicaoestagios form content">
                <?= $this->Form->create($instituicaoestagio) ?>
                <fieldset>
                    <legend><?= __('Edit Instituicaoestagio') ?></legend>
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
</div>