<?php
pr($estagiario);
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiariosView"
        aria-controls="navbarTogglerEstagiariosView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiariosView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item"><?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id]) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo Estagiario'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($estagiario->aluno->nome) ?></h3>
    <table class="table table-striped table-hover table-responsive">
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
        <td><?= $estagiario->has('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?>
        </td>
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
            <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->id, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?>
            </td>
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