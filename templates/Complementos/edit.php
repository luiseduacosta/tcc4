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
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $complemento->id],
                        ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'side-nav-item']
                )
                ?>
                <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="complementos form content">
                <?= $this->Form->create($complemento) ?>
                <fieldset>
                    <legend><?= __('Editar complemento de estágio') ?></legend>
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