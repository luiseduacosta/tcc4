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
        <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
</nav>

<div class="column-responsive column-80">
    <div class="visitas form content">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Nova visita') ?></legend>
            <?php
            echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
            echo $this->Form->control('data');
            echo $this->Form->control('motivo');
            echo $this->Form->control('responsavel');
            echo $this->Form->control('descricao');
            echo $this->Form->control('avaliacao');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
