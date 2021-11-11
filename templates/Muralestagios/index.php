<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
// pr($periodo);
?>
<?php
/*
  var url = "<?= $this->Html->url(['controller' => 'Murals', 'action' => 'index/periodo:']); ?>";
 */
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
<?php
// $this->request->getSession()->write('id_categoria', 1);
$session = $this->getRequest()->getSession();
// echo $this->request->getSession()->read('id_categoria');
// die();
?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if ($session->read('id_categoria') == 1): ?>
            <?= $this->Form->create($muralestagios, ['class' => 'form-inline']); ?>
            <?= $this->Form->input('periodo', ['id' => 'MuralestagioPeriodo', 'type' => 'select', 'label' => ['text' => 'Período'], 'options' => $periodos, 'empty' => [$periodo => $periodo]], ['class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= '2020-1'; ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="muralestagios index container">
    <?php if ($session->read('id_categoria') == 1): ?>
        <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Mural de estagios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('vagas') ?></th>
                    <th><?= $this->Paginator->sort('beneficios') ?></th>
                    <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                    <th><?= $this->Paginator->sort('cargaHoraria', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('dataInscricao', 'Inscrição') ?></th>
                    <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                    <?php if ($session->read('id_categoria') == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralestagios as $muralestagio): ?>
                    <tr>
                        <td><?= $muralestagio->id ?></td>
                        <td><?= $muralestagio->has('instituicaoestagio') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]); ?></td>
                        <td><?= $muralestagio->vagas ?></td>
                        <td><?= h($muralestagio->beneficios) ?></td>
                        <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                        <td><?= $muralestagio->cargaHoraria ?></td>
                        <td><?= $muralestagio->dataInscricao ? h(date('d-m-Y', strtotime($muralestagio->dataInscricao))) : '' ?></td>
                        <td><?= $muralestagio->dataSelecao ? h(date('d-m-Y', strtotime($muralestagio->dataSelecao))) : '' ?></td>
                        <?php if ($session->read('id_categoria') == 1): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $muralestagio->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $muralestagio->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id)]) ?>
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
