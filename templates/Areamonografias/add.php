<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova área de monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($area) ?>
    <fieldset class="border p-2">
        <legend><?= __('Nova área de monografia') ?></legend>
        <?php
        echo $this->Form->control('id');
        echo $this->Form->control('area');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>