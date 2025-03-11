<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiarios);
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<div class="d-flex justify-content-center">
    <?php echo $this->element('menu_esquerdo'); ?>
</div>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Estagiarios por período e por TCC concluída') ?></h3>

    <?= $this->Form->create(null, ['url' => ['action' => 'index']]) ?>
    <?= $this->Form->control('periodo', ['label' => 'Busca por 4º periodo de estágio', 'options' => $periodos]) ?>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>

    <table class="table table-responsive table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('registro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('turno') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo_monog') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $c_estudante): ?>
                <?php // pr($c_estudante) ?>
                <tr>
                    <td><?= h($c_estudante->registro) ?></td>
                    <?php if (!empty($c_estudante->aluno->id)): ?>
                        <td><?= $this->Html->link($c_estudante->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $c_estudante->aluno->id]) ?>
                        </td>
                    <?php else: ?>
                        <td><?= h($c_estudante->tccestudante->nome) ?></td>
                    <?php endif; ?>
                    <td><?= h($c_estudante->turno) ?></td>
                    <td><?= h($c_estudante->nivel) ?></td>
                    <td><?= h($c_estudante->periodo) ?></td>
                    <td><?= $this->Html->link($c_estudante->titulo, ['controller' => 'Monografias', 'action' => 'view', $c_estudante->monografia_id]) ?>
                    </td>
                    <td><?= h($c_estudante->periodo_monog) ?></td>
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