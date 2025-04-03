<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <nav class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?= $this->Html->link(__('Listar complemento'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </nav>
        <div class="column-responsive column-80">
            <div class="complementos form content">
                <?= $this->Form->create($complemento) ?>
                <fieldset>
                    <legend><?= __('Novo registro') ?></legend>
                    <?php
                    echo $this->Form->control('periodo_especial');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>