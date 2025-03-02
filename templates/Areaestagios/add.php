<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>

    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Html->link(__('Listar área de estágios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areaestagios form content">
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Nova área de estágio') ?></legend>
                <?php
                echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
