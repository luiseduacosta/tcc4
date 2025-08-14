<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var \Cake\Collection\CollectionInterface|string[] $questiones
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(__('List Respostas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta) ?>
        <fieldset>
            <legend><?= __('Nova resposta') ?></legend>
            <?php
            echo $this->Form->control('question_id', ['options' => $questiones]);
            echo $this->Form->control('estagiarios_id', ['options' => $estagiarios]);
            echo $this->Form->control('response');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>