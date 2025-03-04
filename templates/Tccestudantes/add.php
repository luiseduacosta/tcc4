<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3 class="text-center"><?= __('Inserir TCC estudante') ?></h3>
    <?= $this->Form->create($tccestudante) ?>
    <fieldset>
        <legend><?= __('Inserir TCC estudante') ?></legend>
        <?php
        if (isset($nome) and isset($registro)):
            echo $this->Form->control('nome', ['value' => $nome]);
            echo $this->Form->control('monografia_id', ['options' => $monografias, 'value' => $monografia_id]);
            echo $this->Form->control('registro', ['value' => $registro]);
        else:
            echo $this->Form->control('nome');
            echo $this->Form->control('monografia_id', ['options' => $monografias, 'empty' => 'Selecione monografia']);
            echo $this->Form->control('registro');
        endif;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
