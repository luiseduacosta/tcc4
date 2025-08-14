<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questione $questione
 * @var \Cake\Collection\CollectionInterface|string[] $questionarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="container">
    <nav class='navbar-expand-lg navbar-light bg-light'>
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar questões'), ['action' => 'index'], ['class' => 'btn btn-primary mt-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questione) ?>
        <fieldset>
            <legend><?= __('Nova questão') ?></legend>
            <?php
            echo $this->Form->control('questionario_id', ['options' => $questionarios]);
            echo $this->Form->control('text', ['label' => 'Texto']);
            echo $this->Form->control('type', ['label' => 'Tipo']);
            echo $this->Form->control('options', ['label' => 'Opções']);
            echo $this->Form->control('order', ['label' => 'Ordem']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>