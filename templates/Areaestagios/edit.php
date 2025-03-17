<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<aside class="column">
    <div class="side-nav">
        <?=
            $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $areaestagio->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areaestagio->id), 'class' => 'btn btn-danger']
            )
            ?>
        <?= $this->Html->link(__('Listar área de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</aside>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($areaestagio) ?>
    <fieldset>
        <legend><?= __('Editar área de estágio') ?></legend>
        <?php
        echo $this->Form->control('area');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>