<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?></li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>
<div class="docentes index large-9 medium-8 columns content">
    <h3><?= __('Docentes') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentes', 'action' => 'index0'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentes', 'action' => 'index1'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentes', 'action' => 'index2'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentes', 'action' => 'index3'], ['class' => 'btn btn-primary float-end']) ?>
        <?php endif; ?>
    </p>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('siape') ?></th>
                <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dataingresso', 'Data ingresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('formaingresso', 'Forma ingresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                <th scope="col"><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?></td>
                    <td><?= h($docente->siape) ?></td>
                    <td><?= h($docente->departamento) ?></td>
                    <td><?= h($docente->dataingresso) ?></td>
                    <td><?= h($docente->formaingresso) ?></td>
                    <td><?= h($docente->tipocargo) ?></td>
                    <td><?= h($docente->categoria) ?></td>
                    <td><?= h($docente->regimetrabalho) ?></td>
                    <td><?= h($docente->dataegresso) ?></td>
                    <td><?= h($docente->motivoegresso) ?></td>
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
