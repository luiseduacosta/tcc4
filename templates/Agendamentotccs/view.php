<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotcc);
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAgendamentosView"
        aria-controls="navbarTogglerAgendamentosView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarToggleeAgendamentosView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Agendar Oficina'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $agendamentotcc->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Agendamentos marcados'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Ata da Oficna'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Declarações de participção'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
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