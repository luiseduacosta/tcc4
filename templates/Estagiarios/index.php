<?php
// pr($estudantes);
$user = $this->getRequest()->getAttribute('identity');
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiarios"
        aria-controls="navbarTogglerEstagiarios" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerEstagiarios"></div>
    <ul class="navbar-nav ms-auto mt-lg-0">
        <?php if (isset($user->role) && $user->role == 'admin'): ?>
            <li class="nav-item"><?= $this->Html->link(__('Novo estagiário'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?></li>
        <?php endif; ?>
    </ul>
    <?= $this->element('menu_esquerdo') ?>
</nav>

<?= $this->element('templates') ?>

<div class="container">
    <h3><?= __('Estagiarios por período e por TCC concluída') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'index']]) ?>
    <?= $this->Form->control('periodo', ['label' => 'Busca por 4º periodo de estágio', 'options' => $periodos, 'value' => $this->getRequest()->getSession()->read('periodo'), 'empty' => true]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('turno') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('periodo_monog') ?></th>                                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudantes as $c_estudante): ?>
                <?php // pr($estagiario->tccestudante->id) ?>
                <tr>
                    <td><?= h($c_estudante['registro']) ?></td>
                    <?php if (!empty($c_estudante['id'])): ?>
                        <td><?= $this->Html->link($c_estudante['nome'], ['controller' => 'Tccestudantes', 'action' => 'view', $c_estudante['id']]) ?></td>
                    <?php else: ?>
                        <td><?= h($c_estudante['nome']) ?></td>                
                    <?php endif; ?>
                    <td><?= h($c_estudante['turno']) ?></td>
                    <td><?= h($c_estudante['nivel']) ?></td>
                    <td><?= h($c_estudante['periodo']) ?></td>
                    <td><?= $this->Html->link($c_estudante['titulo'], ['controller' => 'Monografias', 'action' => 'view', $c_estudante['monografia_id']]) ?></td>                
                    <td><?= h($c_estudante['periodo_monog']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
