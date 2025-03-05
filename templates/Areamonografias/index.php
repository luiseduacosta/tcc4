<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($user);
// die();
// pr($areas);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia[]|\Cake\Collection\CollectionInterface $areas
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAreamonografia"
        aria-controls="navbarTogglerAreamonografia" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAreamonografia">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Html->link(__('Nova área de monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Áreas') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('area') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monografias') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
                <?php // pr(count($area->monografias)); ?>
                <tr>
                    <td><?= $this->Html->link(h($area->area), ['controller' => 'areamonografias', 'action' => 'view', $area->id]) ?>
                    </td>
                    <td><?= $this->Number->format(count($area->monografias)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->element('templates') ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo')) ?>
            <?= $this->Paginator->last(__('último')) ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} do {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
        </p>
    </div>
</div>