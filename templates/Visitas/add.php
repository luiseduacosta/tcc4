<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <h4 class="heading"><?= __('Ações') ?></h4>
        <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Nova visita') ?></legend>
            <?php
            echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
            echo $this->Form->control('data', ['label' => ['text' => 'Data'], 'class' => 'form-control']);
            echo $this->Form->control('motivo', ['label' => ['text' => 'Motivo'], 'class' => 'form-control']);
            echo $this->Form->control('responsavel', ['label' => ['text' => 'Responsável'], 'class' => 'form-control']);
            echo $this->Form->control('descricao', ['label' => ['text' => 'Descrição'], 'class' => 'form-control']);
            echo $this->Form->control('avaliacao', ['label' => ['text' => 'Avaliação'], 'class' => 'form-control']);
            ?>
        </fieldset>
        <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar', ['class' => 'btn btn-primary'])) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
