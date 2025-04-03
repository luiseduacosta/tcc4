<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>
    <nav class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Html->link(__('Editar visita'), ['action' => 'edit', $visita->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Excluir visita'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $visita->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </nav>
    <div class="column-responsive column-80">
        <div class="visitas view content">
            <h3><?= h($visita->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($visita->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <td><?= $visita->has('instituicao') ? $this->Html->link($visita->instituicao['id'], ['controller' => 'Instituicaoestagios', 'action' => 'view', $visita->instituicao['id']]) : '' ?></td>
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
    </div>
</div>
