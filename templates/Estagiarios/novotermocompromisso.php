<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($supervisores);
// pr($supervisor_id);
// pr($instituicoes);
// pr($instituicao_id);
?>

<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural'); ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
        aria-controls="navbarTogglerEstagiario" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiario">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $estagiario->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-start']
                    )
                    ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario, ['method' => 'post']) ?>
    <fieldset class="border p-2">
        <?php if ($nivel == '9'): ?>
            <legend><?= __('Estágio extra-curricular') ?></legend>
        <?php else: ?>
            <legend><?= __('Termo de compromisso') ?></legend>
        <?php endif; ?>
        <?php
        echo $this->Form->control('aluno_id', ['options' => [$aluno_id => $nomealuno], 'required' => true, 'readonly' => true]);
        echo $this->Form->control('registro', ['label' => 'Registro', 'required' => true, 'readonly' => true]);
        echo $this->Form->control('turno', ['hidden' => true, 'label' => false]);
        if ($nivel == '9'):
            echo $this->Form->control('nivel', ['label' => false, 'value' => $nivel, 'hidden' => true, 'readonly' => true]);
        else:
            echo $this->Form->control('nivel', ['value' => $nivel, 'readonly' => true]);
        endif;
        echo $this->Form->control('tc_solicitacao', ['default' => date('Y-m-d'), 'label' => 'Data de solicitação', 'readonly' => true]);
        echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo, 'required' => true, 'readonly' => true]);
        echo $this->Form->control('ajuste2020', ['label' => 'Ajuste 2020', 'options' => ['0' => 'Não', '1' => 'Sim'], 'default' => '1']);

        echo $this->Form->control('instituicao_id', ['value' => $instituicao_id, 'options' => $instituicoes, 'required' => true, 'empty' => 'Seleciona instituição']);

        if (isset($supervisor_id)) {
            echo $this->Form->control('supervisor_id', ['value' => $supervisor_id, 'options' => $supervisores, 'required' => false, 'empty' => "Seleciona supervisor"]);
        } else {
            echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'required' => false, 'empty' => "Seleciona supervisor"]);
        }
        echo $this->Form->control('professor_id', ['options' => $professores, 'required' => false, 'empty' => true]);
        echo $this->Form->control('turmaestagio_id', ['label' => 'Turma', 'options' => $turmaestagios, 'required' => false, 'empty' => true]);
        echo $this->Form->control('nota', ['hidden' => true, 'label' => false]);
        echo $this->Form->control('ch', ['hidden' => true, 'label' => false]);
        echo $this->Form->control('observacoes', ['label' => 'Observações', 'type' => 'textarea', 'rows' => 5, 'cols' => 40, 'default' => '', 'required' => false]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>