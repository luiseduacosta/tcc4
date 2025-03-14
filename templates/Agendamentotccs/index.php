<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotccs);
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAgendamentos"
        aria-controls="navbarTogglerAgendamentos" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAgendamentos">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo Agendamento de Tcc'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Agendamento de Oficina de TCC') ?></h3>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('Alunos.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('Professores.nome', 'Orientador') ?></th>
                <th><?= $this->Paginator->sort('Professores1.nome', 'Banca 1') ?></th>
                <th><?= $this->Paginator->sort('Professores2.nome', 'Banca 2') ?></th>
                <th><?= $this->Paginator->sort('data') ?></th>
                <th><?= $this->Paginator->sort('horario') ?></th>
                <th><?= $this->Paginator->sort('sala') ?></th>
                <th><?= $this->Paginator->sort('titulo') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                <?php // pr($agendamentotcc->professor) ?>
                <tr>
                    <td><?= $agendamentotcc->hasValue('aluno') ? $this->Html->link($agendamentotcc->alunos['nome'], ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->aluno_id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('professor') ? $this->Html->link($agendamentotcc->professores['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professores['id']]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('professores1') ? $this->Html->link($agendamentotcc->professores1->nome, ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professores1->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->has('professores2') ? $this->Html->link($agendamentotcc->professores2->nome, ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professores2->id]) : '' ?>
                    </td>
                    <td><?= h($agendamentotcc->data) ?></td>
                    <td><?= h($agendamentotcc->horario) ?></td>
                    <td><?= h($agendamentotcc->sala) ?></td>
                    <td><?= h($agendamentotcc->titulo) ?></td>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td><?= h($agendamentotcc->avaliacao) ?></td>
                        <td class="row">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $agendamentotcc->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['
                            action' => 'delete',
                                $agendamentotcc->id
                            ], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $agendamentotcc->id)]) ?>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates') ?>

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