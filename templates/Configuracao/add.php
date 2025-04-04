<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="collapse navbar-collapse list-unstyled">
        <li class="nav-item">
            <?= $this->Html->link(__('List Configuracao'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </li>
    </ul>
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