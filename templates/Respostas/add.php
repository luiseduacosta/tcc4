<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var \Cake\Collection\CollectionInterface|string[] $questiones
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->Form->setTemplates(['formStart' => '<form{{attrs}}>']); ?>
<?php $this->Form->setTemplates(['formEnd' => '</form>']); ?>
<?php $this->Form->setTemplates(['fieldset' => '<fieldset class="border p-3 mb-4" {{attrs}}>{{content}}</fieldset>']); ?>
<?php $this->Form->setTemplates(['select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>']); ?>
<?php $this->Form->setTemplates(['option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>']); ?>
<?php $this->Form->setTemplates(['legend' => '<legend class="h3">{{text}}</legend>']); ?>
<?php $this->Form->setTemplates(['label' => '<label class="form-label" {{attrs}}>{{text}}</label>']); ?>
<?php $this->Form->setTemplates(['input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}>']); ?>
<?php $this->Form->setTemplates(['radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>']); ?>
<?php $this->Form->setTemplates(['radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}']); ?>
<?php $this->Form->setTemplates(['textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>']); ?>
<?php $this->Form->setTemplates(['requiredClass' => 'required']); ?>
<?php $this->Form->setTemplates(['submitContainer' => '<div class="Confirma">{{content}}</div>']); ?>
<?php $this->Form->setTemplates(['button' => '<button{{attrs}}>{{text}}</button>']); ?>

<div class="container mt-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar respostas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta) ?>
        <fieldset>
            <legend><?= $aluno->nome . ' estagiário nível ' . $estagiario->nivel ?></legend>
            <?php foreach ($questiones as $questione): ?>
                <?php
                // pr("resposta_" . $questione->id);
                $opcoes = $questione->options ? json_decode($questione->options, true) : [];
                ?>
                <?php
                echo $this->Form->control('questione_id', [
                    'type' => 'hidden',
                    'value' => $questione->id
                ]);
                echo $this->Form->control('estagiario_id', [
                    'type' => 'hidden',
                    'value' => $estagiario_id
                ]);
                if ($questione->type === 'select') {
                    $opcoes = array_combine($opcoes, $opcoes);
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => $questione->type, 'options' => $opcoes, 'empty' => 'Seleciona', 'class' => 'form-control']);
                } elseif ($questione->type === 'radio' || $questione->type === 'checkbox') {
                    $opcoes = array_combine($opcoes, $opcoes);
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => $questione->type, 'options' => $opcoes]);
                } elseif ($questione->type === 'boolean') {
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => 'checkbox', 'options' => ['0' => 'Não', '1' => 'Sim']]);
                } elseif ($questione->type === 'scale') {
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => 'number', 'min' => 1, 'max' => 5, 'class' => 'form-control']);
                } elseif ($questione->type === 'text' || $questione->type === 'textarea') {
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => $questione->type, 'class' => 'form-control']);
                } else {
                    echo $this->Form->control('avaliacao' . $questione->id, ['label' => $questione->text, 'type' => 'text', 'class' => 'form-control']);
                }
                echo $this->Form->control('created', [
                    'type' => 'hidden',
                    'value' => date('Y-m-d H:i:s')
                ]);
                echo $this->Form->control('modified', [
                    'type' => 'hidden',
                    'value' => date('Y-m-d H:i:s')
                ]);
                ?>
            <?php endforeach; ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>