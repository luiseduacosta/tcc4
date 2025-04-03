<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($muralinscricao);
?>
<div class="row">
    <?php echo $this->element('menu_mural') ?>
</div>

<aside class="column">
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
</aside>

<?= $this->element('tempaltes') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($muralinscricao) ?>
    <fieldset>
        <legend><?= __('Editar Muralinscricao') ?></legend>
        <?php
        echo $this->Form->control('registro', ['value' => $muralinscricao->aluno['registro'], 'readonly' => true]);
        echo $this->Form->control('estudante_id', ['options' => [$muralinscricao->aluno['id'] => $muralinscricao->aluno['nome']], 'empty' => $muralinscricao->aluno['nome'], 'readonly' => true]);
        echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
        echo $this->Form->control('data');
        echo $this->Form->control('periodo');
        echo $this->Form->control('timestamp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>