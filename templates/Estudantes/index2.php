<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
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
    </h3>
</div>

<div class="row">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <th><?= $this->Paginator->sort('endereco') ?></th>
                <th><?= $this->Paginator->sort('cep') ?></th>
                <th><?= $this->Paginator->sort('municipio') ?></th>
                <th><?= $this->Paginator->sort('bairro') ?></th>
                <th><?= $this->Paginator->sort('observacoes') ?></th>
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
