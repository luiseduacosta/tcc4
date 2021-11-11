<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
<div class="alunos index content">
    <?= $this->Html->link(__('New Aluno'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Alunos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('nascimento') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('identidade') ?></th>
                    <th><?= $this->Paginator->sort('orgao') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('endereco') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('observacoes') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= $aluno->id ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?></td>
                    <td><?= $aluno->registro ?></td>
                    <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->identidade) ?></td>
                    <td><?= h($aluno->orgao) ?></td>
                    <td><?= h($aluno->email) ?></td> 
                    <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                    <td><?= h($aluno->telefone) ?></td>
                    <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                    <td><?= h($aluno->celular) ?></td>
                    <td><?= h($aluno->cep) ?></td>
                    <td><?= h($aluno->endereco) ?></td>
                    <td><?= h($aluno->municipio) ?></td>
                    <td><?= h($aluno->bairro) ?></td>
                    <td><?= h($aluno->observacoes) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aluno->id)]) ?>
                    </td>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
