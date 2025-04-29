<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <?= $this->Html->link(__('Editar visita'), ['controller' => 'Visitas', 'action' => 'edit', $visita->id], ['class' => 'side-nav-item']) ?>
        <?= $this->Form->postLink(__('Excluir visita'), ['controller' => 'Visitas', 'action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $visita->id), 'class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Listar visitas'), ['controller' => 'Visitas', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Nova visita'), ['controller' => 'Visitas', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($visita->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Instituição') ?></th>
                <td><?= $visita->has('instituicao') ? $this->Html->link($visita->instituicao['id'], ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao['id']]) : '' ?></td>
            </tr>
            <tr>
                <th><?= __('Motivo') ?></th>
                <td><?= h($visita->motivo) ?></td>
            </tr>
            <tr>
                <th><?= __('Responsável') ?></th>
                <td><?= h($visita->responsavel) ?></td>
            </tr>
            <tr>
                <th><?= __('Avaliação') ?></th>
                <td><?= h($visita->avaliacao) ?></td>
            </tr>
            <tr>
                <th><?= __('Data') ?></th>
                <td><?= h($visita->data) ?></td>
            </tr>
        </table>
        <div class="text">
            <strong><?= __('Descrição') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($visita->descricao)); ?>
            </blockquote>
        </div>
</div>
