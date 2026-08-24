<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
$user = $this->getRequest()->getAttribute('identity');

// Load DataTables Bootstrap 5 CSS and JS in layout blocks
$this->Html->css('https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css', ['block' => true]);
$this->Html->script([
    'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js',
    'https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'
], ['block' => true]);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
        aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerProfessor">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item me-1">
                <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Professores', 'action' => 'buscaprofessor'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Busca professor(a)',
                    'class' => 'form-control'
                ])
                    ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor1" role="tab" aria-controls="professor1"
                    aria-selected="true">Dados funcionais</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor4" role="tab" aria-controls="professor4"
                    aria-selected="true">Comunicação</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor5" role="tab" aria-controls="professor5"
                    aria-selected="true">Curriculo</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="professor1" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('CPF') ?></th>
                        <th><?= __('SIAPE') ?></th>
                        <th><?= __('CRESS') ?></th>
                        <th><?= __('Região') ?></th>
                        <th><?= __('Departamento') ?></th>
                        <th><?= __('Data de ingresso') ?></th>
                        <th><?= __('Data de egresso') ?></th>
                        <th><?= __('Motivo de egresso') ?></th>
                        <th><?= __('Status') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= $professor->siape ?></td>
                            <td><?= h($professor->cress) ?></td>
                            <td><?= h($professor->regiao) ?></td>
                            <td><?= h($professor->departamento) ?></td>
                            <td><?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->motivoegresso) ?></td>
                            <td><?= h($professor->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor4" class="tab-pane container fade">
            <h3><?= __('Comunicação') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Código de telefone') ?></th>
                        <th><?= __('Telefone') ?></th>
                        <th><?= __('Código de celular') ?></th>
                        <th><?= __('Celular') ?></th>
                        <th><?= __('E-mail') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->codigo_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->codigo_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>    
    </div>

    <div class="tab-content">
        <div id="professor5" class="tab-pane container fade">
            <h3><?= __('Curriculo') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Curriculo') ?></th>
                        <th><?= __('Atualização') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->curriculolattes) ?></td>
                            <td><?= h($professor->atualizacaolattes) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>    
    </div>

    <?= $this->element('templates') ?>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function() {
    $('.professores-table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
        },
        "pageLength": 25,
        "ordering": true,
        "stateSave": true
    });
});
<?php $this->Html->scriptEnd(); ?>