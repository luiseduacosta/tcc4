<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante[]|\Cake\Collection\CollectionInterface $estudantes
 */
?>
<div class="estudantes index container">
    <?php echo $this->element('menu_mural') ?>
    <h3><?= __('Estudantes') ?></h3>
    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
        <?= $this->Html->link(__('Novo estudante'), ['action' => 'add'], ['class' => 'button float-right']) ?>
        <div class="row justify-content-left">
            <div class="col-auto">
                <?= $this->Form->create($estudantes, ['url' => ['action' => 'view'], 'type' => 'get'], ['class' => 'form-inline']); ?>
                <?= $this->Form->input('registro', ['type' => 'input', 'label' => ['text' => 'Registro'], 'empty' => true], ['class' => 'form-control']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
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
                <?php foreach ($estudantes as $estudante): ?>
                    <tr>
                        <td><?= $estudante->id ?></td>
                        <td><?= $this->Html->link($estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $estudante->id]) ?></td>
                        <td><?= $estudante->registro ?></td>
                        <td><?= $estudante->nascimento ? date('d-m-Y', strtotime($estudante->nascimento)) : '' ?></td>
                        <td><?= h($estudante->cpf) ?></td>
                        <td><?= h($estudante->identidade) ?></td>
                        <td><?= h($estudante->orgao) ?></td>
                        <td><?= h($estudante->email) ?></td>
                        <td><?= $this->Number->format($estudante->codigo_telefone) ?></td>
                        <td><?= h($estudante->telefone) ?></td>
                        <td><?= $this->Number->format($estudante->codigo_celular) ?></td>
                        <td><?= h($estudante->celular) ?></td>
                        <td><?= h($estudante->cep) ?></td>
                        <td><?= h($estudante->endereco) ?></td>
                        <td><?= h($estudante->municipio) ?></td>
                        <td><?= h($estudante->bairro) ?></td>
                        <td><?= h($estudante->observacoes) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $estudante->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estudante->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estudante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estudante->id)]) ?>
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
