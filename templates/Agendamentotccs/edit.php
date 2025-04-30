<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $agendamentotcc->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $agendamentotcc->id), 'class' => 'btn btn-danger']
                    ) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo Agendamento de Tcc'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($agendamentotcc) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar agendamento de defesa de TCC') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['options' => $alunos]);
        echo $this->Form->control('professor_id', ['options' => $professores]);
        echo $this->Form->control('banca1', ['options' => $professores]);
        echo $this->Form->control('banca2', ['options' => $professores]);
        echo $this->Form->control('convidado', ['label' => 'Convidado(a)']);
        echo $this->Form->control('data', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
        echo $this->Form->control('horario', ['type' => 'time', 'templates' => ['dateWidget' => '{{HH}}{{mm}}{{ss}}']]);
        echo $this->Form->control('sala');
        echo $this->Form->control('titulo');
        echo $this->Form->control('avaliacao');
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar', ['class' => 'btn btn-primary'])) ?>
    </div>
    <?= $this->Form->end() ?>
</div>