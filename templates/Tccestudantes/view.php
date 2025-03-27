<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($tccestudante);
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_monografias') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerTccestudantesView"
        aria-controls="navbarTogglerTccestudantesview" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerTccestudantesView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $tccestudante->id], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $tccestudante->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $tccestudante->id), 'class' => 'btn btn-danger float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($tccestudante->nome) ?></h3>
    <table class="table table-striped table-hover">
        <tr>
            <td scope="row"><?= __('Id') ?></td>
            <td><?= h($tccestudante->id) ?></td>
        </tr>
        <tr>
            <td scope="row"><?= __('Registro') ?></td>
            <td><?= h($tccestudante->registro) ?></td>
        </tr>
        <tr>
            <td scope="row"><?= __('Nome') ?></td>
            <?php if (!empty($tccestudante->aluno)): ?>
                <td><?= $this->Html->link($tccestudante->aluno['nome'], ['controller' => 'estudantes', 'action' => 'view', $tccestudante->aluno['id']]) ?>
                </td>
            <?php else: ?>
                <td><?= h($tccestudante->nome) ?></td>
            <?php endif ?>
        </tr>
        <tr>
            <td scope="row"><?= __('Monografia') ?></td>
            <td><?= $this->Html->link($tccestudante->monografia['titulo'], ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografia['id']]) ?>
            </td>
        </tr>
    </table>
</div>