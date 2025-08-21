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

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">        
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __ ('Excluir'),
                    ['action' => 'delete', $muralinscricao->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralinscricao->id), 'class' => 'btn btn-primary']
                    )
                ?>
        </li>
    <?php endif; ?>
        <li class='nav-link'>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
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
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>