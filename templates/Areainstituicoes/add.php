<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
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
</div>
