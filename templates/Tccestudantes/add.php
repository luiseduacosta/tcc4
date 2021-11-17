<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?= $this->element('menu_monografias') ?>
    </ul>
</nav>
<div class="tccestudantes form large-9 medium-8 columns content">
    <?= $this->Form->create($tccestudante) ?>
    <fieldset>
        <legend><?= __('Inserir estudante de TCC') ?></legend>
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
