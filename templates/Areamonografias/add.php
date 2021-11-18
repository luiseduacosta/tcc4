<?php

$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>

<div class="row justify-content-center">
    <?php echo $this->element('menu_monografias'); ?>        
</div>

<div class="areas form large-9 medium-8 columns content">
    <?= $this->Form->create($area) ?>
    <fieldset>
        <legend><?= __('Nova área') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('area');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
