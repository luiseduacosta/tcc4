<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $muralinscricao->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricao->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Muralinscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralinscricoes form content">
            <?= $this->Form->create($muralinscricao) ?>
            <fieldset>
                <legend><?= __('Edit Muralinscricao') ?></legend>
                <?php
                    echo $this->Form->control('registro');
                    echo $this->Form->control('estudante_id', ['options' => $estudantes, 'empty' => true]);
                    echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('timestamp');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
