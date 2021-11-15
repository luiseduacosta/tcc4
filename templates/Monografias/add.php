<?php

$user = $this->getRequest()->getAttribute('identity');
// pr($estudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?= $this->element('menu_monografias'); ?>
    </ul>
</nav>
<div class="monografias form large-9 medium-8 columns content">
    <?= $this->Form->create($monografia, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Inserir nova monografia') ?></legend>
        <?php
            echo $this->Form->control('registro', ['options' => $estudantes, 'empty' => 'Seleciona estudante']);
            // echo $this->Form->control('catalogo');
            echo $this->Form->textarea('titulo', ['label' => 'Título', 'rows' => '3']);
            echo $this->Form->textarea('resumo', ['label' => 'Resumo', 'rows' => '5']);
            echo $this->Form->control('data_de_entrega', ['label' => 'Data de entrega', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
            echo $this->Form->control('ano', ['type' => 'year', 'minYear' => date('Y')-10, 'maxYear' => date('Y')]); 
            echo $this->Form->control('semestre', ['options' => ['0' => 'Sem dados', '1' => '1º', '2' => '2º']]);            
            echo $this->Form->control('docente_id', ['label' => 'Orientador(a)', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('co_orienta_id', ['label' => 'Co-orientador(a)', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('areamonografia_id', ['label' => 'Área', 'options' => $areas, 'empty' => 'Seleciona área']);
            echo $this->Form->control('data_banca', ['label' => 'Data da banca', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
            echo $this->Form->control('banca1', ['label' => 'Banca Professor(a) orientador', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('banca2', ['label' => 'Banca Professor(a)', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('banca3', ['label' => 'Banca Professor(a)', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('convidado');
            echo $this->Form->control('url', ['label' => 'Inserir monografia em PDF', 'type' => 'file']);
            // echo $this->Form->control('timestamp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
