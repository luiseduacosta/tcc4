<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstudantesView"
            aria-controls="navbarTogglerEstudantesView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstudantesView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-primary float-start']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $aluno->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($aluno->nome) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($aluno->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <td><?= h($aluno->registro) ?></td>
        </tr>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <tr>
                <th><?= __('Nascimento') ?></th>
                <td><?= h($aluno->nascimento) ?></td>
            </tr>
            <tr>
                <th><?= __('Telefone') ?></th>
                <td><?= '(' . h($aluno->codigo_telefone) . ')' . h($aluno->telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Celular') ?></th>
                <td><?= '(' . h($aluno->codigo_celular) . ')' . h($aluno->celular) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($aluno->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Cpf') ?></th>
                <td><?= h($aluno->cpf) ?></td>
            </tr>
            <tr>
                <th><?= __('Identidade') ?></th>
                <td><?= h($aluno->identidade) ?></td>
            </tr>
            <tr>
                <th><?= __('Orgao') ?></th>
                <td><?= h($aluno->orgao) ?></td>
            </tr>
            <tr>
                <th><?= __('Endereço') ?></th>
                <td><?= h($aluno->endereco) ?></td>
            </tr>
            <tr>
                <th><?= __('Cep') ?></th>
                <td><?= h($aluno->cep) ?></td>
            </tr>
            <tr>
                <th><?= __('Município') ?></th>
                <td><?= h($aluno->municipio) ?></td>
            </tr>
            <tr>
                <th><?= __('Bairro') ?></th>
                <td><?= h($aluno->bairro) ?></td>
            </tr>
            <tr>
                <th><?= __('Observacoes') ?></th>
                <td><?= h($aluno->observacoes) ?></td>
            </tr>
        <?php endif; ?>
    </table>
</div>