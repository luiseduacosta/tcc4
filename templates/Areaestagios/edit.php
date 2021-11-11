<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $areaestagio->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $areaestagio->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Areaestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areaestagios form content">
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Edit Areaestagio') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
