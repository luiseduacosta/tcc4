<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($tccestudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante[]|\Cake\Collection\CollectionInterface $tccestudantes
 */
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'button float-right']) ?></li>
        <?php endif; ?>
        <?php echo $this->element('menu_esquerdo'); ?>        
    </ul>
</nav>

<div class="tccestudantes index large-9 medium-8 columns content">
    <h3><?= __('Estudantes') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('nome', ['label' => 'Busca por nome']) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
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
                    <td><?= $this->Html->link(h($tccestudante->nome), ['controller' => 'tccestudantes', 'action' => 'view', $tccestudante->id]) ?></td>
                    <td><?= $tccestudante->has('monografia')? $this->Html->link(h($tccestudante->monografia->titulo), ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografia->id]): "" ?></td>
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
