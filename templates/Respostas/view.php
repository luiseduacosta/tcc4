<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 */
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="container">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#resposta"
            aria-controls="resposta" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="resposta">
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resposta->id), 'class' => 'btn btn-danger']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <h3><?= h($resposta->id) ?></h3>
        <table class="table table-responsive table-striped table-hover">
            <tr>
                <th><?= __('Questões') ?></th>
                <td><?= $resposta->has('questione') ? $this->Html->link($resposta->questione->type, ['controller' => 'Questiones', 'action' => 'view', $resposta->questione->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Estagiario') ?></th>
                <td><?= $resposta->has('estagiario') ? $this->Html->link($resposta->estagiario->periodo, ['controller' => 'Estagiarios', 'action' => 'view', $resposta->estagiario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($resposta->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= h($resposta->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= h($resposta->modified) ?></td>
            </tr>
        </table>
        <div class="text">
            <strong><?= __('Resposta') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($resposta->response)); ?>
            </blockquote>
        </div>
    </div>
</div>