<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var string[]|\Cake\Collection\CollectionInterface $questiones
 * @var string[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $resposta->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $resposta->id), 'class' => 'btn btn-danger']
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar respostas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta) ?>
        <fieldset>
            <legend><?= __('Editar resposta') ?></legend>
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