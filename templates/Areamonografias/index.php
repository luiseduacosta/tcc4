<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($user);
// die();
// pr($areas);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area[]|\Cake\Collection\CollectionInterface $areas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->role) && $user->role == 'admin'): ?>
            <li><?= $this->Html->link(__('Nova Área'), ['action' => 'add'], ['class' => 'button float-right']) ?></li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>
<div class="areas index large-9 medium-8 columns content">
    <h3><?= __('Áreas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('area') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monografias') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
            <?php // pr($area); ?>            
                <tr>
                    <td><?= $area->has('areamonografia') ? $this->Html->link(h($area->areamonografia->area), ['controller' => 'areamonografias', 'action' => 'view', $area->areamonografia_id]): "" ?></td>
                    <td><?= $area->qarea ?></td>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>        
    </div>
</div>
