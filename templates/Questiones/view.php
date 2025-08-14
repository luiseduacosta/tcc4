<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questione $questione
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="row">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questione->id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questione->id), 'class' => 'btn btn-danger']) ?>
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
        <h3><?= h($questione->type) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Questionario') ?></th>
                <td><?= $questione->has('questionario') ? $this->Html->link($questione->questionario->title, ['controller' => 'Questionarios', 'action' => 'view', $questione->questionario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Type') ?></th>
                <td><?= h($questione->type) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questione->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Order') ?></th>
                <td><?= $questione->order === null ? '' : $this->Number->format($questione->order) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($questione->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($questione->modified) ?></td>
            </tr>
        </table>
        <div class="text">
            <strong><?= __('Text') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($questione->text)); ?>
            </blockquote>
        </div>
        <div class="text">
            <strong><?= __('Options') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($questione->options)); ?>
            </blockquote>
        </div>
    </div>
</div>