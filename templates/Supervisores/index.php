<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores
 */
// pr($supervisores);
$user = $this->getRequest()->getAttribute('identity');
// pr($user['categoria']);
?>
<div class="supervisores index container">
    <?php echo $this->element('menu_mural') ?>
    <?php if ($user['categoria'] == 1): ?>
        <?= $this->Html->link(__('Cadastra supervisora'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Supervisores(as)') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cress') ?></th>
                    <th><?= $this->Paginator->sort('regiao') ?></th>
                    <th><?= $this->Paginator->sort('codigo_tel', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_cel', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <?php if ($user['categoria'] == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervisores as $supervisor): ?>
                    <tr>
                        <td><?= $supervisor->id ?></td>
                        <?php if ($user['categoria'] == 1): ?>
                            <td><?= $this->Html->link($supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]) ?></td>
                        <?php else: ?>
                            <td><?= $supervisor->nome ?></td>
                        <?php endif; ?>
                        <td><?= $supervisor->cress ?></td>
                        <td><?= $supervisor->regiao ?></td>
                        <td><?= h($supervisor->codigo_tel) ?></td>
                        <td><?= h($supervisor->telefone) ?></td>
                        <td><?= h($supervisor->codigo_cel) ?></td>
                        <td><?= h($supervisor->celular) ?></td>
                        <td><?= h($supervisor->email) ?></td>
                        <?php if ($user['categoria'] == 1): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $supervisor->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $supervisor->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id)]) ?>
                            </td>
                        <?php endif; ?>
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
