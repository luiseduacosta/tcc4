<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $aluno->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $aluno->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Alunos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="alunos form content">
            <?= $this->Form->create($aluno) ?>
            <fieldset>
                <legend><?= __('Edit Aluno') ?></legend>
                <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('registro');
                    echo $this->Form->control('nascimento', ['empty' => true]);
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('identidade');
                    echo $this->Form->control('orgao');
                    echo $this->Form->control('email');
                    echo $this->Form->control('codigo_telefone');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('codigo_celular');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
