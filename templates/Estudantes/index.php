<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button float-right']) ?></li>
        <?php endif; ?>
        <?php echo $this->element('menu_esquerdo'); ?>
    </ul>
</nav>
<div class="alunos index large-9 medium-8 columns content">
    <h3>
        <?= __('Estudantes') ?>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__(' Identificação'), ['action' => 'index1'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link(__(' Comunicação'), ['action' => 'index'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link(__(' Endereço'), ['action' => 'index2'], ['class' => 'button float-right']) ?>
        <?php endif; ?>
    </h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'estudantes', 'action' => 'view', $aluno->id]) ?></td>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <?php if ($aluno->telefone): ?>
                            <td><?= '(' . h($aluno->codigo_telefone) . ')' . h($aluno->telefone) ?></td>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>
                        <?php if ($aluno->celular): ?>
                            <td><?= '(' . h($aluno->codigo_celular) . ')' . h($aluno->celular) ?></td>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>
                        <td><?= h($aluno->email) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
