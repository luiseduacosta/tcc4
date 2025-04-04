<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAlunosEdit"
        aria-controls="navbarTogglerAlunosEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAlunosEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $aluno->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $aluno->id), 'class' => 'btn btn-danger float-start']
                )
                ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo aluno'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar Aluno') ?></legend>
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