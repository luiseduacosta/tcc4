<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($user->categoria);
// pr($tccestudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante[]|\Cake\Collection\CollectionInterface $tccestudantes
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerTccEstudantes"
        aria-controls="navbarTogglerTccEstudantes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerTccEstudantes">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Estudantes') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('nome', ['label' => 'Busca por nome']) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes.id', 'Id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes.registro', 'DRE') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes.nome', 'Estudante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.titulo', 'Título') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tccestudantes as $tccestudante): ?>
                <?php // pr($tccestudante); ?>
                <tr>
                    <td><?= $this->Number->format($tccestudante->id) ?></td>
                    <td><?= h($tccestudante->registro) ?></td>
                    <td><?= $this->Html->link(h($tccestudante->nome), ['controller' => 'tccestudantes', 'action' => 'view', $tccestudante->id]) ?>
                    </td>
                    <td><?= $tccestudante->has('monografia') ? $this->Html->link(h($tccestudante->monografia->titulo), ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografia->id]) : "" ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>