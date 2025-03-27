<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('observacoes')
</script>

<?= $this->element('templates') ?>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?=
        $this->Form->postLink(
            __('Excluir'),
            ['action' => 'delete', $estagiario->id],
            ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-start']
        )
        ?>
<?php endif; ?>
<?= $this->Html->link(__('Novo aluno'), ['controller' => 'Alunos', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
<?= $this->Html->link(__('Novo professor'), ['controller' => 'Professores', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>

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
        echo $this->Form->control('instituicao_id', ['options' => $instituicoes]);
        echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
        echo $this->Form->control('professor_id', ['options' => $professores, 'empty' => true]);
        echo $this->Form->control('periodo');
        echo $this->Form->control('id_area', ['label' => 'Área', 'options' => $turmaestagios, 'empty' => true]);
        echo $this->Form->control('nota');
        echo $this->Form->control('ch', ['label' => 'Carga horária']);
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>
