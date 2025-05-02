<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAtividades">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class='nav-link'>
                <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class='nav-link'>
                <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class='nav-link'>
                <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-rigth']) ?>
            </li>
        <?php endif; ?>    
        <li class='nav-link'>
            <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($folhadeatividade->atividade) ?></h3>
    <table class="table table-striped table-hover table-responsive">
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

