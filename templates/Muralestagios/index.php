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

<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-center">
    <div class="col-auto">
        <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
            <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == '1'): ?>
            <?= $this->Form->create($muralestagios, ['class' => 'form-inline']); ?>
            <?= $this->Form->input('periodo', ['id' => 'MuralestagioPeriodo', 'type' => 'select', 'label' => ['text' => 'Período'], 'options' => $periodos, 'empty' => [$periodo => $periodo]], ['class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-end">
    <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
    <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == '1'): ?>
        <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
    <?php endif; ?>
</div>

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