<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante[]|\Cake\Collection\CollectionInterface $estudantes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstudantes"
            aria-controls="navbarTogglerEstudantes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstudantes">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo(a) estuante'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="d-flex justify-content-end">
    <h3>
        <?= __('Estudantes') ?>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__(' Comunicação'), ['action' => 'index'], ['class' => 'btn btn-secondary float-end']) ?>
            <?= $this->Html->link(__(' Endereço'), ['action' => 'index2'], ['class' => 'btn btn-secondary float-end']) ?>
            <?= $this->Html->link(__(' Identificação'), ['action' => 'index1'], ['class' => 'btn btn-secondary float-end']) ?>
        <?php endif; ?>
    </h3>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-hover table-responsive table-striped">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                <th><?= $this->Paginator->sort('identidade', 'Identidade') ?></th>
                <th><?= $this->Paginator->sort('orgao', 'Orgão') ?></th>
                <th><?= $this->Paginator->sort('nascimento', 'Data de nascimento') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'estudantes', 'action' => 'view', $aluno->id]) ?>
                    </td>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->identidade) ?></td>
                    <td><?= h($aluno->orgao) ?></td>
                    <td><?= h($aluno->nascimento) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>