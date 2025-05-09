<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotcc);
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Agendar Oficina'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar'), ['controller' => 'Agendamentotccs', 'action' => 'edit', $agendamentotcc->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Agendamentotccs', 'action' => 'delete', $agendamentotcc->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $agendamentotcc->id), 'class' => 'btn btn-danger float-start']) ?>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Agendamentos marcados'), ['controller' => 'Agendamentotccs', 'action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Ata da Oficina'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Declarações de participação'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        </ul>
    </div>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($agendamentotcc->aluno['nome']) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Aluno') ?></th>
            <td><?= $agendamentotcc->has('aluno') ? $this->Html->link($agendamentotcc->aluno['nome'], ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->aluno['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Docente') ?></th>
            <td><?= $agendamentotcc->has('professor') ? $this->Html->link($agendamentotcc->professor['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professor['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Banca1') ?></th>
            <td><?= $agendamentotcc->has('bancaprofessor1') ? $this->Html->link($agendamentotcc->professorbanca1['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professorbanca1['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Banca2') ?></th>
            <td><?= $agendamentotcc->has('bancaprofessor2') ? $this->Html->link($agendamentotcc->professorbanca2['nome'], ['controller' => 'Professores', 'action' => 'view', $agendamentotcc->professorbanca2['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Convidado') ?></th>
            <td><?= h($agendamentotcc->convidado) ?></td>
        </tr>
        <tr>
            <th><?= __('Titulo') ?></th>
            <td><?= h($agendamentotcc->titulo) ?></td>
        </tr>
        <tr>
            <th><?= __('Sala') ?></th>
            <td><?= h($agendamentotcc->sala) ?></td>
        </tr>
        <tr>
            <th><?= __('Data') ?></th>
            <td><?= h($agendamentotcc->data->format('d-m-Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('Horario') ?></th>
            <td><?= h($agendamentotcc->horario->i18nFormat('HH:mm:ss')) ?></td>
        </tr>
        <tr>
            <th><?= __('Avaliacao') ?></th>
            <td><?= h($agendamentotcc->avaliacao) ?></td>
        </tr>
    </table>
</div>