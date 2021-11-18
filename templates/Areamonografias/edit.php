<?php
$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<div class="row justify-content-center">
    <?php echo $this->element('menu_monografias'); ?>        
</div>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <li><?=
        $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $area->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $area->id), 'class' => 'btn btn-danger float-right']
        )
        ?></li>
<?php endif; ?>

<div class="areas form large-9 medium-8 columns content">
    <?= $this->Form->create($area) ?>
    <fieldset>
        <legend><?= __('Editar área') ?></legend>
        <?php
        echo $this->Form->control('id');
        echo $this->Form->control('area');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
