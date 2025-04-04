<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($muralinscricao);
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <?=
        $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $muralinscricao->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'side-nav-item']
        )
        ?>
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($muralinscricao) ?>
    <fieldset>
        <legend><?= __('Editar inscrição') ?></legend>
        <?php
        echo $this->Form->control('registro', ['value' => $muralinscricao->alunos['registro'], 'readonly' => true]);
        echo $this->Form->control('aluno_id', ['options' => [$muralinscricao->alunos['id'] => $muralinscricao->alunos['nome']], 'empty' => $muralinscricao->alunos['nome'], 'readonly' => true]);
        echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
        echo $this->Form->control('data');
        echo $this->Form->control('periodo');
        echo $this->Form->control('timestamp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>