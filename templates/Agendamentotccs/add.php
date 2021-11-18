<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($alunos);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
?>
<div class="row justify-content-center">
    <?= $this->element('menu_monografias') ?>
</div>
<?= $this->Html->link(__('Agendamento de TCCs'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
<div class="column-responsive column-80">
    <div class="agendamentotccs form content">
        <?= $this->Form->create($agendamentotcc) ?>
        <fieldset>
            <legend><?= __('Agendamento de oficina de defesa de TCC') ?></legend>
            <?php
            echo $this->Form->control('aluno_id', ['label' => 'Estudante', 'options' => $alunos, 'empty' => 'Seleciona']);
            echo $this->Form->control('docente_id', ['label' => 'Professor(a)', 'options' => $docentes, 'empty' => 'Seleciona']);
            echo $this->Form->control('banca1', ['label' => 'Banca', 'options' => $docentes, 'empty' => 'Seleciona']);
            echo $this->Form->control('banca2', ['label' => 'Banca', 'options' => $docentes, 'empty' => 'Seleciona']);
            echo $this->Form->control('data', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
            echo $this->Form->control('horario', ['type' => 'time', 'templates' => ['dateWidget' => '{{HH}}{{mm}}{{ss}}']]);
            echo $this->Form->control('sala', ['label' => 'Sala. Colocar 0 se for não-presencial']);
            echo $this->Form->control('convidado');
            echo $this->Form->control('titulo', ['label' => 'Título da monografia']);
            echo $this->Form->control('avaliacao');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
</div>
