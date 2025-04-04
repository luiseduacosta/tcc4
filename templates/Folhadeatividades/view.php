<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<div class='row'>
    <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-rigth']) ?>
</div>

<div class="column-responsive column-80">
    <div class="folhadeatividades view content">
        <h3><?= h($folhadeatividade->atividade) ?></h3>
        <table>
            <tr>
                <th><?= __('Atividade') ?></th>
                <td><?= h($folhadeatividade->atividade) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $folhadeatividade->id ?></td>
            </tr>
            <tr>
                <th><?= __('Estagiário') ?></th>
                <td><?= $folhadeatividade->estagiario_id ?></td>
            </tr>
            <tr>
                <th><?= __('Día') ?></th>
                <td><?= h($folhadeatividade->dia) ?></td>
            </tr>
            <tr>
                <th><?= __('Início') ?></th>
                <td><?= h($folhadeatividade->inicio) ?></td>
            </tr>
            <tr>
                <th><?= __('Final') ?></th>
                <td><?= h($folhadeatividade->final) ?></td>
            </tr>
            <tr>
                <th><?= __('Horário') ?></th>
                <td><?= h($folhadeatividade->horario) ?></td>
            </tr>
        </table>
    </div>
</div>
