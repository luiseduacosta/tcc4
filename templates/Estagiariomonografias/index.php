<?php
// pr($estudantes);
$user = $this->getRequest()->getAttribute('identity');
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiarios"
            aria-controls="navbarTogglerEstagiarios" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerEstagiarios">
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiarios">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo estagiário'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Estagiarios por período e por TCC concluída') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'index']]) ?>
    <?= $this->Form->control('periodo', ['label' => 'Busca por 4º periodo de estágio', 'options' => $periodos, 'value' => $this->getRequest()->getSession()->read('periodo'), 'empty' => $periodo]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
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
                <?php // pr($c_estudante) ?>
                <tr>
                    <td><?= h($c_estudante['registro']) ?></td>
                    <?php if (!empty($c_estudante['id'])): ?>
                        <td><?= $this->Html->link($c_estudante['nome'], ['controller' => 'Tccestudantes', 'action' => 'view', $c_estudante['id']]) ?>
                        </td>
                    <?php else: ?>
                        <td><?= h($c_estudante['nome']) ?></td>
                    <?php endif; ?>
                    <td><?= h($c_estudante['turno']) ?></td>
                    <td><?= h($c_estudante['nivel']) ?></td>
                    <td><?= h($c_estudante['periodo']) ?></td>
                    <td><?= $this->Html->link($c_estudante['titulo'], ['controller' => 'Monografias', 'action' => 'view', $c_estudante['monografia_id']]) ?>
                    </td>
                    <td><?= h($c_estudante['periodo_monog']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>