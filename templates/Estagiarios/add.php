<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<?php echo $this->element('menu_monografias'); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstagiarioAdd"
            aria-controls="navbarTogglerEstagiarioAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiarioAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Estagiário') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => 'Seleciona estudante']);
        echo $this->Form->control('registro');
        echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido']]);
        echo $this->Form->control('nivel', ['options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4]]);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso', 'options' => ['0' => 'Sem TC', '1' => 'Com TC']]);
        echo $this->Form->control('tc_solicitacao', ['empty' => true]);
        echo $this->Form->control('instituicao_id', ['label' => 'Instituição', 'options' => $instituicoes]);
        echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
        echo $this->Form->control('professor_id', ['options' => $professores, 'empty' => true]);
        $digito = ((date('m')) > 6) ? '-2' : '-1';
        echo $this->Form->control('periodo', ['value' => date('Y') . $digito]);
        echo $this->Form->control('id_area', ['label' => 'Área de estágio', 'options' => $turmaestagios, 'empty' => true]);
        echo $this->Form->control('nota');
        echo $this->Form->control('ch', ['label' => 'Carga horária']);
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>