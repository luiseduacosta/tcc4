<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Açoes') ?></h4>
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $userestagio->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'side-nav-item']
                )
                ?>
                <?= $this->Html->link(__('Listar usuário de estágios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="userestagios form content">
                <?= $this->Form->create($userestagio) ?>
                <fieldset>
                    <legend><?= __('Editar  usuário') ?></legend>
                    <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('categoria');
                    echo $this->Form->control('numero');
                    echo $this->Form->control('estudante_id', ['options' => $estudantes, 'empty' => true]);
                    echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
                    echo $this->Form->control('docente_id', ['options' => $docentes, 'empty' => true]);
                    echo $this->Form->control('timestamp');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>