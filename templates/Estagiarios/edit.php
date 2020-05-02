<?php

$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->role) && $user->role == 'admin'): ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $estagiario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]
            )
        ?></li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
        <li><?= $this->Html->link(__('New Aluno'), ['controller' => 'Alunos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('New Docente'), ['controller' => 'Docentes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="estagiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($estagiario) ?>
    <fieldset>
        <legend><?= __('Edit Estagiario') ?></legend>
        <?php
            echo $this->Form->control('aluno_id', ['options' => $alunos]);
            echo $this->Form->control('registro');
            echo $this->Form->control('turno');
            echo $this->Form->control('nivel');
            echo $this->Form->control('tc');
            echo $this->Form->control('tc_solicitacao', ['empty' => true]);
            echo $this->Form->control('instituicao_id');
            echo $this->Form->control('supervisor_id');
            echo $this->Form->control('docente_id', ['options' => $docentes, 'empty' => true]);
            echo $this->Form->control('periodo');
            echo $this->Form->control('id_area', ['label' => 'Área', 'options' => $areas, 'empty' => true]);
            echo $this->Form->control('nota');
            echo $this->Form->control('ch', ['label' => 'Carga horária']);
            echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
