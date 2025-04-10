<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($periodo);
// pr($muralestagios);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'muralestagios', 'action' => 'index']); ?>";
        // alert(url);
        $("#MuralestagioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + '/index/' + periodo;
        })

    })
</script>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMural">
            <li class="nav-item">
                <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
            </li>
        </ul>
    <?php endif; ?>
</nav>

<?php if (isset($user) && $user['categoria'] == '1'): ?>
    <?= $this->Form->create($muralestagios); ?>
    <div class="d-flex justify-content-center">
        <div class="col-1 p-3">
            <label class="form-label" for="MuralestagioPeriodo">Período</label>
        </div>
        <div class="col-1 p-2">
            <?= $this->Form->input('periodo', ['id' => 'MuralestagioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
<?php else: ?>
    <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></h1>
<?php endif; ?>

<?= $this->element('templates') ?>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Mural de estagios') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('vagas') ?></th>
                <th><?= $this->Paginator->sort('beneficios') ?></th>
                <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                <th><?= $this->Paginator->sort('cargaHoraria', 'CH') ?></th>
                <th><?= $this->Paginator->sort('dataInscricao', 'Inscrição') ?></th>
                <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
                <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == '1'): ?>
                    <th class="actions"><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muralestagios as $muralestagio): ?>
                <tr>
                    <td><?= $muralestagio->id ?></td>
                    <td><?= $muralestagio->has('instituicaoestagio') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]); ?>
                    </td>
                    <td><?= $muralestagio->vagas ?></td>
                    <td><?= h($muralestagio->beneficios) ?></td>
                    <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                    <td><?= $muralestagio->cargaHoraria ?></td>
                    <td><?= isset($muralestagio->dataInscricao) ? $muralestagio->dataInscricao : '' ?></td>
                    <td><?= isset($muralestagio->dataSelecao) ? $muralestagio->dataSelecao : '' ?></td>
                    <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
                    <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == '1'): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id)]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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