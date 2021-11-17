<?php
$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>

        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'side-nav-item']) ?></li>
            <li><?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $aluno->id], ['class' => 'side-nav-item']) ?></li>
            <li><?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $aluno->id), 'class' => 'side-nav-item']) ?></li>
        <?php endif; ?>

        <li>
            <?= $this->Html->link(__('Listar Estudantes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </li>
    </ul>
</nav>
<div class="alunos view large-9 medium-8 columns content">
    <div class="alunos view content">
        <h3><?= h($aluno->nome) ?></h3>
        <table>
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
</div>
