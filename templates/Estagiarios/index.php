<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiarios);
// pr($periodo);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'index']); ?>";
        // alert(url);
        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index?periodo=');
            window.location = url + '/index?periodo=' + periodo;
        })

    })
</script>

<?php echo $this->element('menu_mural') ?>

<?php if (isset($user) && $user->categoria == '1'): ?>
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
            aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMural">
            <li class="nav-item">
                <?= $this->Html->link(__('Novo Estagiário'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<div class="f-flex justify-content-center py-2">
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <?= $this->Form->create($estagiarios); ?>
        <div class="form-group row">
            <label for='EstagiarioPeriodo' class="col-sm-1 col-form-label p-2">Período</label>
            <div class="col-sm-1 p-1">
                <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    <?php else: ?>
        <h1 style="text-align: center;">Estagiários da ESS/UFRJ. Período: <?= $periodo ?></h1>
    <?php endif; ?>
</div>

<?= $this->element('templates') ?>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Estagiarios') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('Estagiarios.id', 'Id') ?></th>
                <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('ajuste2020', 'Ajuste 2020') ?></th>
                <th><?= $this->Paginator->sort('turno') ?></th>
                <th><?= $this->Paginator->sort('nivel') ?></th>
                <th><?= $this->Paginator->sort('tc') ?></th>
                <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicao') ?></th>
                <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('Docentes.nome', 'Professor(a)') ?></th>
                <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('Turmaestagio.area', 'Turma de estágio') ?></th>
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('nota') ?></th>
                    <th><?= $this->Paginator->sort('nota') ?></th>
                    <th><?= $this->Paginator->sort('Estagiarios.ch', 'Carga horária') ?></th>
                    <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    <th class="row"><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <?php // pr($estagiario); ?>
                    <td><?= $this->Html->link($estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $estagiario->id]) ?>
                    </td>
                    <td><?= $estagiario->hasValue('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno_id]) : '' ?>
                    </td>
                    <td><?= $estagiario->registro ?></td>
                    <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                    <td><?= h($estagiario->turno) ?></td>
                    <td><?= h($estagiario->nivel) ?></td>
                    <td><?= $estagiario->tc ?></td>
                    <?php if (isset($estagiario->tc_solicitacao)): ?>
                        <td><?= date('d-m-Y', strtotime(h($estagiario->tc_solicitacao))) ?></td>
                    <?php else: ?>
                        <td>Sem dados</td>
                    <?php endif; ?>
                    <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?>
                    </td>
                    <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : 'Sem dados' ?>
                    </td>
                    <td><?= $estagiario->hasValue('professor') ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : 'Sem dados' ?>
                    </td>
                    <td><?= h($estagiario->periodo) ?></td>
                    <td><?= $estagiario->hasValue('turmaestagio') ? $this->Html->link($estagiario->turmaestagio->area, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->turmestagio_id]) : '' ?>
                    </td>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <?php if (isset($estagiario->nota)): ?>
                            <td><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                        <?php else: ?>
                            <td>Sem nota</td>
                        <?php endif; ?>
                        <?php if (isset($estagiario->ch)): ?>
                            <td><?= $this->Number->format($estagiario->ch) ?></td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                        <td><?= h($estagiario->observacoes) ?></td>
                        <td class="row">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id]) ?>
                            <?php if (isset($user) && $user->categoria == 1): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id)]) ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <?= $this->element('templates') ?>
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
        </div>
    </div>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>