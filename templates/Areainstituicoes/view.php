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
                    <?= $this->Html->link(__('Editar área instituição'), ['action' => 'edit', $areainstituicao->id], ['class' => 'side-nav-item']) ?>
                </li>
                <li class='nav-link'>
                    <?= $this->Form->postLink(__('Excluir área instituição'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']) ?>
                </li>
                <li class='nav-link'>
                    <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
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
    <h3><?= h($areainstituicao->id) ?></h3>
    <table class='table table-responsive table-striped table-hover'>
            <tr>
                <th><?= __('Área') ?></th>
                <td><?= h($areainstituicao->area) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($areainstituicao->id) ?></td>
            </tr>
    </table>
</div>
