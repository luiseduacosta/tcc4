<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="visitas form content">
            <?= $this->Form->create($visita) ?>
            <fieldset>
                <legend><?= __('Add Visita') ?></legend>
                <?php
                    echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('motivo');
                    echo $this->Form->control('responsavel');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('avaliacao');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
