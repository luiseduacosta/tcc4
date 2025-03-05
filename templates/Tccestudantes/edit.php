<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias)

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-collapse navbar-expand-lg" id="actions-sidebar">
    
    <ul class="nav navbar-nav">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class=""><?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $tccestudante->numero],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $tccestudante->numero), 'class' => 'btn btn-danger float-start']
                    )
                    ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($tccestudante) ?>
    <fieldset>
        <legend><?= __('Editar estudante autor de TCC') ?></legend>
        <div class="form-group row">
            <label class="col-form-label col-2" for="nome">Estudante</label>
            <div class="col-10">
                <input type="text" class="form-control" value="<?= $tccestudante->nome ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="registro">Registro</label>
            <div class="col-10">
                <input type="text" class="form-control" value="<?= $tccestudante->registro ?>" readonly>
            </div>
        </div>
        <?php
        echo $this->Form->control('monografia_id', ['label' => 'Monografia']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>