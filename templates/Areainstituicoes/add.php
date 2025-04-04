<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
</nav>

<div class="column-responsive column-80">
    <div class="areainstituicoes form content">
        <?= $this->Form->create($areainstituicao) ?>
        <fieldset>
            <legend><?= __('Nova área instituição') ?></legend>
            <?php
            echo $this->Form->control('area');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

