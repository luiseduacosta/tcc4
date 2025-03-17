<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light btn-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAreamonografiaEdit"
        aria-controls="navbarTogglerAreamonografiaEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAreamonografiaEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                    $this->Form->postLink(
                        __('Excluir área da monografia'),
                        ['action' => 'delete', $areamonografia->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $areamonografia->id), 'class' => 'btn btn-danger float-start']
                    )
                    ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($areamonografia) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar área da monografia') ?></legend>
        <?php
        echo $this->Form->control('id');
        echo $this->Form->control('area', ['label' => 'Área da monografia']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>