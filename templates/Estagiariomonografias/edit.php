<?php

$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <li><?= $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $estagiario->id],
                ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id)]
            )
        ?></li>
        <?php endif; ?>
        <?= $this->element('menu_monografias') ?>
        <li><?= $this->Html->link(__('Novo estudante'), ['controller' => 'estudantes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Novo docente'), ['controller' => 'docentemonografias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="estagiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($estagiariomonografia) ?>
    <fieldset>
        <legend><?= __('Editar estagiário') ?></legend>
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
