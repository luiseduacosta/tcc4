<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questione $questione
 * @var string[]|\Cake\Collection\CollectionInterface $questionarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="row">
    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $questione->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $questione->id), 'class' => 'btn btn-danger']
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar questões'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questione) ?>
        <fieldset>
            <legend><?= __('Edit Questione') ?></legend>
            <?php
            echo $this->Form->control('questionario_id', ['options' => $questionarios, 'label' => 'Questionario']);
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
