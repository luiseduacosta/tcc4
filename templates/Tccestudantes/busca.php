<?php
// pr($estudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTccestudantesBusca"
        aria-controls="navbarTogglerTccestudantesBusca" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerTccestudantesBusca">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo(a) estudante autor(a) de TCC'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Estudantes') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('nome', ['label' => 'Busca por nome', 'value' => $this->getRequest()->getSession()->read('estudante')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudantes as $estudante): ?>
                <?php if (isset($estudante->monografia->id) && !empty($estudante->monografia->id)): ?>
                    <tr>
                        <td><?= h($estudante->id) ?></td>
                        <td><?= h($estudante->registro) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->nome)), ['action' => 'view', $estudante->id]) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->monografia->titulo)), ['controller' => 'monografias', 'action' => 'view', $estudante->monografia->id]) ?>
                        </td>
                        <td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= h($estudante->id) ?></td>
                        <td><?= h($estudante->registro) ?></td>
                        <td><?= $this->Html->link(__(h($estudante->nome)), ['action' => 'view', $estudante->id]) ?></td>

                        <td>Estudante sem monografia?</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
        </div>
    </div>
</div>