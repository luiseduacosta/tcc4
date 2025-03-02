<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($tccestudante);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerTccestudantesView"
        aria-controls="navbarTogglerTccestudantesview" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerTccestudantesView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item"><?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $tccestudante->id], ['class' => 'btn btn-primary float-end']) ?> </li>
            <li class="nav-item"><?= $this->Form->postLink(__('Delete Estudante'), ['action' => 'delete', $tccestudante->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $tccestudante->id), 'class' => 'btn btn-danger float-ende']) ?> </li>
        <?php endif; ?>
    </ul>
</nav>
<div class="container">
    <h3><?= h($tccestudante->Nome) ?></h3>
    <table class="table table-striped table-hover">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($tccestudante->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro') ?></th>
            <td><?= h($tccestudante->registro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($tccestudante->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monografia') ?></th>
            <td><?= $this->Html->link($tccestudante->monografia->titulo, ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografia->id]) ?></td>
        </tr>
    </table>
</div>
