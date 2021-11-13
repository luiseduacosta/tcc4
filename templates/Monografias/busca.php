<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Nova Monografia'), ['action' => 'add']) ?></li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>
<div class="monografias index large-9 medium-8 columns content">
    <h3><?= __('Monografias') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('titulo', ['label' => 'Busca por título', 'value' => $this->getRequest()->getSession()->read('busca')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tccestudantes->nome', 'Estudante') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('nome', 'Orientador(a)') ?></th>
                <th scope="col"><?= $this->Paginator->sort('area_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url', 'PDF') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monografias as $monografia): ?>
                <?php // pr($monografia->tccestudantes); ?>
                <tr>
                    <td><?= $this->Html->link(__(h($monografia->titulo)), ['action' => 'view', $monografia->id]) ?></td>
                    <td><?= h($monografia->periodo) ?></td>
                    <td>
                        <?php
                        if (!(empty($monografia->tccestudantes))):
                            $q_estudantes = count($monografia->tccestudantes);
                            foreach ($monografia->tccestudantes as $tccestudantes):
                                // pr($tccestudantes);
                                echo $this->Html->link($tccestudantes->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudantes->id]);
                                if ($q_estudantes > 1):
                                    echo ", ";
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </td> 
                    <td><?= $this->Html->link(h($monografia->docente->nome), ['controller' => 'docentes', 'action' => 'view', $monografia->docente->id]) ?></td>
                    <td><?= $monografia->has('area') ? $this->Html->link($monografia->area->area, ['controller' => 'Areas', 'action' => 'view', $monografia->area->id]) : '' ?></td>
                    <td><?= $this->Html->link($monografia->url, '/monografias/' . $monografia->url, ['download' => $monografia->url]) ?></td>
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
