<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
<<<<<<< HEAD
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if (isset($user->role) && $user->role == 'admin'): ?>
            <li><?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button float-right']) ?></li>
        <?php endif; ?>
        <?php echo $this->element('menu_esquerdo'); ?>
    </ul>
</nav>

<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Estudantes') ?>
        <?= $this->Html->link(__(' Identificação'), ['controlle' => 'estudanates', 'action' => 'index1'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__(' Comunicação'), ['controlle' => 'estudanates', 'action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__(' Endereço'), ['controlle' => 'estudanates', 'action' => 'index2'], ['class' => 'btn btn-primary float-end']) ?>
=======

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstudantesIndex2"
        aria-controls="navbarTogglerEstudantesIndex2" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstudantesIndex2">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo(a) estuante'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <h3>
        <?= __('Estudantes') ?>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__(' Comunicação'), ['action' => 'index'], ['class' => 'btn btn-secondary float-end']) ?>
            <?= $this->Html->link(__(' Endereço'), ['action' => 'index2'], ['class' => 'btn btn-secondary float-end']) ?>
            <?= $this->Html->link(__(' Identificação'), ['action' => 'index1'], ['class' => 'btn btn-secondary float-end']) ?>
        <?php endif; ?>
>>>>>>> f4568cb (Fix issues)
    </h3>
</div>

<div class="row">
<<<<<<< HEAD
    <table cellpadding="0" cellspacing="0">
        <thead>
=======
    <table class="table  table-striped table-hover table-responsive">
        <thead class="table-dark">
>>>>>>> f4568cb (Fix issues)
            <tr>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                <th><?= $this->Paginator->sort('municipio') ?></th>
                <th><?= $this->Paginator->sort('bairro') ?></th>
                <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'estudantes', 'action' => 'view', $aluno->id]) ?>
                    </td>
                    <td><?= h($aluno->endereco) ?></td>
                    <td><?= h($aluno->cep) ?></td>
                    <td><?= h($aluno->municipio) ?></td>
                    <td><?= h($aluno->bairro) ?></td>
                    <td><?= h($aluno->observacoes) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<<<<<<< HEAD
</div>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>
=======

<?php $this->element('templates') ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>
>>>>>>> f4568cb (Fix issues)
