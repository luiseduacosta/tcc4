<?php
$usuario = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
                )
                ?></li>
<?php endif; ?>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
        echo $this->Form->control('email');
        echo $this->Form->control('password');
        echo $this->Form->control('categoria', ['options' => ['2' => 'estudante', '3' => 'professor', '4' => 'supervisor']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
