<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotcc);
// pr($docentes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
?>
<div class="row justify-content-center">
    <?= $this->element('menu_monografias') ?>
</div>
<div class="row">
    <?= $this->Html->link(__('Agendamento de banca de TCC'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>    
</div>
<div class="column-responsive column-80">
    <div class="agendamentotccs form content">
        <?= $this->Form->create($agendamentotcc) ?>
        <fieldset>
            <legend><?= __('Editar agendamento de defesa de TCC') ?></legend>
            <?php
            echo $this->Form->control('estudante_id', ['options' => $alunos]);
            echo $this->Form->control('docente_id', ['options' => $docentes]);
            echo $this->Form->control('banca1', ['options' => $docentes]);
            echo $this->Form->control('banca2', ['options' => $docentes]);
            echo $this->Form->control('data', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
            echo $this->Form->control('horario', ['type' => 'time', 'templates' => ['dateWidget' => '{{HH}}{{mm}}{{ss}}']]);
            echo $this->Form->control('sala');
            echo $this->Form->control('convidado');
            echo $this->Form->control('titulo');
            echo $this->Form->control('avaliacao');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
</div>
