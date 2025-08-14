<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAreainstituicoes"
        aria-controls="navbarTogglerAreainstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAreainstituicoes">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'edit', $areainstituicao->id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'edit', $areainstituicao->id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>        
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar área instituições'), ['controller' => 'Areainstituicoes', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <div class="areainstituicoes view content">
        <h3><?= h($areainstituicao->id) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Área') ?></th>
                <td><?= h($areainstituicao->area) ?></td>
            </tr>
            <tr>
                <th><?= __('ID') ?></th>
                <td><?= $this->Number->format($areainstituicao->id) ?></td>
            </tr>
        </table>
    </div>
</div>

