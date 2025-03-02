<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotcc);
// pr($docentes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $agendamentotcc->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $agendamentotcc->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Agendamentotccs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
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
