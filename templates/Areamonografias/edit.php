<?php
$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?=
            $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $area->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $area->id)]
            )
            ?></li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo'); ?>
    </ul>
</nav>
<div class="areas form large-9 medium-8 columns content">
    <?= $this->Form->create($area) ?>
    <fieldset>
        <legend><?= __('Edit Area') ?></legend>
        <?php
        echo $this->Form->control('id');
        echo $this->Form->control('area');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
