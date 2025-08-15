<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questione $questione
 * @var string[]|\Cake\Collection\CollectionInterface $questionarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="container mt-1">
    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $questione->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $questione->id), 'class' => 'btn btn-danger me-1']
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar questões'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questione) ?>
        <fieldset>
            <legend><?= __('Editar') ?></legend>
            <?php
            echo $this->Form->control('questionario_id', ['options' => $questionarios, 'label' => 'Questionario']);
            echo $this->Form->control('text', ['label' => 'Texto']);
            echo $this->Form->control('type', ['label' => 'Tipo (text, textarea, select, scale, boolean)', 'options' => ['text' => 'text', 'textarea' => 'textarea', 'radio' => 'radio', 'select' => 'select', 'scale' => 'scale (1 - 5)', 'boolean' => 'boolean (sim/não)'], 'class' => 'form-control']);
            echo $this->Form->control('options', ['label' => 'Opções']);
            echo $this->Form->control('ordem', ['label' => 'Ordem']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
