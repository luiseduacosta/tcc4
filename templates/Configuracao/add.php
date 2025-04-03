<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>
    <nav class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Configuracao'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </nav>
    <div class="column-responsive column-80">
        <div class="configuracao form content">
            <?= $this->Form->create($configuracao) ?>
            <fieldset>
                <legend><?= __('Configuração') ?></legend>
                <?php
                echo $this->Form->control('mural_periodo_atual');
                echo $this->Form->control('termo_compromisso_periodo');
                echo $this->Form->control('termo_compromisso_inicio');
                echo $this->Form->control('termo_compromisso_final');
                echo $this->Form->control('curso_turma_atual');
                echo $this->Form->control('curso_abertura_inscricoes');
                echo $this->Form->control('curso_encerramento_inscricoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
