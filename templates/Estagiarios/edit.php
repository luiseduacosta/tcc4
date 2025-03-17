<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiariosEdit"
            aria-controls="navbarTogglerEstagiariosEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiariosEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link"><?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $estagiario->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger flota-start']
                )
                ?></li>
            <?php endif; ?>
        <li class="nav-link">
<?= $this->Html->link(__('New Aluno'), ['controller' => 'Alunos', 'action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
        <li class="nav-link">
<?= $this->Html->link(__('New Docente'), ['controller' => 'Professores', 'action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
<?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar estagiário') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['options' => $alunos]);
        echo $this->Form->control('registro');
        echo $this->Form->control('turno');
        echo $this->Form->control('nivel');
        echo $this->Form->control('tc');
        echo $this->Form->control('tc_solicitacao', ['empty' => true]);
        echo $this->Form->control('instituicao_id');
        echo $this->Form->control('supervisor_id');
        echo $this->Form->control('professor_id', ['options' => $Professores, 'empty' => true]);
        echo $this->Form->control('periodo');
        echo $this->Form->control('id_area', ['label' => 'Área', 'options' => $areas, 'empty' => true]);
        echo $this->Form->control('nota');
        echo $this->Form->control('ch', ['label' => 'Carga horária']);
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
<?= $this->Form->end() ?>
</div>