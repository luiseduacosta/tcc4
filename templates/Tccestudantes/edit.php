<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $tccestudante->numero],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $tccestudante->numero)]
                )
                ?></li>
        <?php endif; ?>
        <?= $this->element('menu_monografias') ?>    
    </ul>
</nav>
<div class="tccestudantes form large-9 medium-8 columns content">
    <?= $this->Form->create($tccestudante) ?>
    <fieldset>
        <legend><?= __('Edit Tccestudante') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('monografia_id', ['label' => 'Monografia']);
        echo $this->Form->control('registro');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
