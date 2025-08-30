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

<div class="container mt-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $resposta->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar respostas'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta) ?>
        <fieldset>
            <legend><?= __('Editar resposta') ?></legend>
            <?php
            echo $this->Form->control('question_id', [
                'options' => $questiones
            ]);
            echo $this->Form->control('estagiarios_id', [
                'options' => $estagiarios
            ]);
            $respostas = json_decode($resposta->response, true);
            // pr($respostas);
            foreach ($respostas as $key => $value) {
                echo $this->Form->control($key, [
                    'value' => $value,
                    'label' => $key,
                    'type' => 'textarea',
                    'required' => true
                ]);
                // pr($key . ' - ' . $value);
            }
            // echo $this->Form->control('response', ['value' => json_decode($resposta->response), 'label' => ['text' => 'Resposta'], 'type' => 'textarea', 'required' => true]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>