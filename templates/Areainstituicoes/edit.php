<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>
    <nav class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?=
            $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $areainstituicao->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']
            )
            ?>
<?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </nav>
    <div class="column-responsive column-80">
        <div class="areainstituicoes form content">
                <?= $this->Form->create($areainstituicao) ?>
            <fieldset>
                <legend><?= __('Editar área instituição') ?></legend>
                <?php
                echo $this->Form->control('area');
                ?>
            </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
        </div>
    </div>
</div>
