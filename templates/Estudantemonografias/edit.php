<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
$user = $this->getRequest()->getAttribute('identity');
?>



<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li>
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $estudante->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estudante->id), 'class' => 'btn btn-danger float-start']
                    )
                    ?>
            </li>
        <?php endif; ?>
        <li>
            <?= $this->Html->link(__('Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estudante) ?>
    <fieldset class="table-dark">
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
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>