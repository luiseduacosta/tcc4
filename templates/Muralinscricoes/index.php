<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao[]|\Cake\Collection\CollectionInterface $muralinscricoes
 */
// pr($muralinscricoes);

?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'muralinscricoes', 'action' => 'index']); ?>";
        // alert(url);
        $("#MuralinscricoesPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + '/index/' + periodo;
        })

    })
</script>

<?php
?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
            <?= $this->Form->create($muralinscricoes, ['class' => 'form-inline']); ?>
            <?= $this->Form->input('periodo', ['id' => 'MuralinscricoesPeriodo', 'type' => 'select', 'label' => ['text' => 'Período ', 'style' => 'display: inline;'], 'options' => $periodos, 'empty' => [$periodo => $periodo]], ['class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Inscrições para seleção de estágio da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="muralinscricoes index content">
    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inscrições para seleção de estágio') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_aluno', 'Registro') ?></th>
                    <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                    <th><?= $this->Paginator->sort('Muralestagios.instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralinscricoes as $muralinscricao): ?>
                    <tr>
                        <td><?= $muralinscricao->id ?></td>                        
                        <td><?= $muralinscricao->id_aluno ?></td>
                        <td><?= $muralinscricao->has('aluno') ? $this->Html->link($muralinscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno_id]) : '' ?></td>                        
                        <td><?= $muralinscricao->has('estudante') ? $this->Html->link($muralinscricao->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $muralinscricao->alunonovo_id]) : '' ?></td>
                        <td><?= $muralinscricao->has('muralestagio') ? $this->Html->link($muralinscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio->id]) : '' ?></td>
                        <td><?= date('d-m-Y', strtotime(h($muralinscricao->data))) ?></td>
                        <td><?= h($muralinscricao->periodo) ?></td>
                        <td><?= h($muralinscricao->timestamp) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralinscricao->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralinscricao->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id)]) ?>
                        </td>
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
