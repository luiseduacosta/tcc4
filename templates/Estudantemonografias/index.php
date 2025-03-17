<?php 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-center">
    <?php echo $this->element('menu_monografias'); ?>
</div>

<div class="d-flex justify-content-start">
    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <li><?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
        </li>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-end">
    <h3>
        <?= __('Estudantes') ?>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__(' Identificação'), ['action' => 'index1'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link(__(' Comunicação'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link(__(' Endereço'), ['action' => 'index2'], ['class' => 'btn btn-primary float-end']) ?>
        <?php endif; ?>
    </h3>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive-">
        <thead class="table-dark">
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
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'estudantemonografias', 'action' => 'view', $aluno->id]) ?>
                    </td>
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
    <?= $this->element('templates') ?>
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