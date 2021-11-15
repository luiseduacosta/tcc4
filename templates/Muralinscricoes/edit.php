<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
// pr($muralinscricao);
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $muralinscricao->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralinscricoes form content">
            <?= $this->Form->create($muralinscricao) ?>
            <fieldset>
                <legend><?= __('Editar Muralinscricao') ?></legend>
                <?php
                    echo $this->Form->control('registro', ['value' => $muralinscricao->estudante->registro, 'readonly']);
                    echo $this->Form->control('estudante_id', ['options' => [$muralinscricao->estudante->id => $muralinscricao->estudante->nome], 'empty' => $muralinscricao->estudante->nome, 'readonly']);
                    echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('timestamp');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
