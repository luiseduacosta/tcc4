<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="f-flex justify-content-center">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAlunos"
        aria-controls="navbarTogglerAlunos" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAlunos">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo aluno'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Alunos') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                <th><?= $this->Paginator->sort('telefone') ?></th>
                <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                <th><?= $this->Paginator->sort('celular') ?></th>
                <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    <th class="row"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= $aluno->id ?></td>
                    <td><?= $aluno->registro ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                    </td>
                    <?php if (empty($aluno->nascimento)): ?>
                        <td>Sem dados</td>
                    <?php else: ?>
                        <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
                    <?php endif; ?>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->identidade) ?></td>
                    <td><?= h($aluno->orgao) ?></td>
                    <td><?= h($aluno->email) ?></td>
                    <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                    <td><?= h($aluno->telefone) ?></td>
                    <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                    <td><?= h($aluno->celular) ?></td>
                    <td><?= h($aluno->observacoes) ?></td>
                    <td class="row">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id)]) ?>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php $this->element('templates') ?>

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