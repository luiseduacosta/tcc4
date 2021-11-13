<?php
pr($estagiario);
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Edit Estagiario'), ['action' => 'edit', $estagiario->id]) ?> </li>
            <li><?= $this->Form->postLink(__('Delete Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?> </li>
            <li><?= $this->Html->link(__('New Estagiario'), ['action' => 'add']) ?> </li>
            <li><?= $this->Html->link(__('New Aluno'), ['controller' => 'Alunos', 'action' => 'add']) ?> </li>
            <li><?= $this->Html->link(__('New Docente'), ['controller' => 'Docentes', 'action' => 'add']) ?> </li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>
<div class="estagiarios view large-9 medium-8 columns content">
    <h3><?= h($estagiario->aluno->nome) ?></h3>
    <table class="vertical-table">
        <tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($estagiario->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro') ?></th>
            <td><?= h($estagiario->registro) ?></td>
        </tr>

        <th scope="row"><?= __('Estudante') ?></th>
        <td><?= $estagiario->has('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Turno') ?></th>
            <td><?= h($estagiario->turno) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nivel') ?></th>
            <td><?= h($estagiario->nivel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Docente') ?></th>
            <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->id, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Periodo') ?></th>
            <td><?= h($estagiario->periodo) ?></td>
        </tr>
        <th scope="row"><?= __('Tc') ?></th>
        <td><?= $this->Number->format($estagiario->tc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tc Solicitacao') ?></th>
            <td><?= h($estagiario->tc_solicitacao) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Id Instituicao') ?></th>
            <td><?= $this->Number->format($estagiario->id_instituicao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id Supervisor') ?></th>
            <td><?= $this->Number->format($estagiario->id_supervisor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id Area') ?></th>
            <td><?= $this->Number->format($estagiario->id_area) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota') ?></th>
            <td><?= $this->Number->format($estagiario->nota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ch') ?></th>
            <td><?= $this->Number->format($estagiario->ch) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Observacoes') ?></th>
            <td><?= h($estagiario->observacoes) ?></td>
        </tr>
        <tr>

    </table>
</div>
