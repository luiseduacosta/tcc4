<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user) && $user->categoria = '1') ?>                
            <li class='nav-link'>
                    <?=
                        $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $areainstituicao->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'btn btn-danger']
                        )
                    ?>
                </li>
            <?php endif; ?>
                <li class='nav-link'>
                    <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </li>
            </ul>
        </div>
    </div>            
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
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
