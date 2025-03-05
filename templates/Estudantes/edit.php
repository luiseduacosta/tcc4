<?php
$user = $this->getRequest()->getAttribute('identity');

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $estudante->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $estudante->id), 'class' => 'side-nav-item']
                )
                ?>
            </li>    
        <?php endif; ?>
        <li>
            <?= $this->Html->link(__('Estudantes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </li>
        <?= $this->element('menu_esquerdo'); ?>       
    </ul>
</nav>    

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <div class="alunos form content">
        <?= $this->Form->create($estudante) ?>
        <fieldset>
            <legend><?= __('Editar estudante') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('registro');
            echo $this->Form->control('codigo_telefone');
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_celular');
            echo $this->Form->control('celular');
            echo $this->Form->control('email');
            echo $this->Form->control('cpf');
            echo $this->Form->control('identidade');
            echo $this->Form->control('orgao');
            echo $this->Form->control('nascimento', ['empty' => true]);
            echo $this->Form->control('endereco');
            echo $this->Form->control('cep');
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
