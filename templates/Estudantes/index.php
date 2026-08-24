<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante[]|\Cake\Collection\CollectionInterface $alunos
 */
$user = $this->getRequest()->getAttribute('identity');
$this->Html->css('https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css', ['block' => true]);
$this->Html->script([
    'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js',
    'https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'
], ['block' => true]);
?>

<?= $this->element('menu_monografias') ?>

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="mb-0 text-dark">
        <i class="bi bi-people-fill me-2 text-secondary"></i><?= __('Estudantes') ?>
    </h3>
    <div>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('<i class="bi bi-person-plus-fill me-1"></i>' . __('Novo(a) estudante'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm', 'escape' => false]) ?>
        <?php endif; ?>
    </div>
</div>

<div class="container-fluid shadow p-4 mb-5 bg-white rounded">
    <div class="table-responsive">
        <table id="estudantes-table" class="table table-striped table-hover align-middle w-100">
            <thead class="table-dark">
                <tr>
                    <th><?= __('Registro') ?></th>
                    <th><?= __('Nome') ?></th>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <th><?= __('CPF') ?></th>
                        <th><?= __('Identidade') ?></th>
                        <th><?= __('Nascimento') ?></th>
                        <th><?= __('Telefone') ?></th>
                        <th><?= __('Celular') ?></th>
                        <th><?= __('E-mail') ?></th>
                        <th><?= __('Endereço') ?></th>
                        <th><?= __('Observações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td class="fw-bold"><?= h($aluno->registro) ?></td>
                        <td><?= $this->Html->link($aluno->nome, ['controller' => 'Estudantes', 'action' => 'view', $aluno->id], ['class' => 'text-decoration-none fw-semibold']) ?>
                        </td>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= h($aluno->cpf) ?></td>
                            <td><?= h($aluno->identidade) ?><?= $aluno->orgao ? ' (' . h($aluno->orgao) . ')' : '' ?></td>
                            <td><?= $aluno->nascimento ? h($aluno->nascimento->format('d/m/Y')) : '' ?></td>
                            <td>
                                <?php if ($aluno->telefone): ?>
                                    <?= '(' . h($aluno->codigo_telefone) . ') ' . h($aluno->telefone) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($aluno->celular): ?>
                                    <?= '(' . h($aluno->codigo_celular) . ') ' . h($aluno->celular) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= h($aluno->email) ?></td>
                            <td>
                                <?= h($aluno->endereco) ?>
                                <?= $aluno->bairro ? ', ' . h($aluno->bairro) : '' ?>
                                <?= $aluno->municipio ? ', ' . h($aluno->municipio) : '' ?>
                                <?= $aluno->cep ? ' - CEP: ' . h($aluno->cep) : '' ?>
                            </td>
                            <td><small class="text-muted"><?= h($aluno->observacoes) ?></small></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function() {
$('#estudantes-table').DataTable({
"language": {
"url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
},
"pageLength": 25,
"ordering": true,
"stateSave": true,
"columnDefs": [
{ "orderable": false, "targets": <?php echo (isset($user) && $user->categoria == '1') ? '[8, 9]' : '[]'; ?> }
]
});
});
<?php $this->Html->scriptEnd(); ?>