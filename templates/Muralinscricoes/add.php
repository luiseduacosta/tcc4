<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($alunonovos);
// pr($alunoestagios);
// die();
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Inscrição para seleção de estágio') ?></legend>
        <?php
        if (isset($user->categoria) && $user->categoria == 1):
            echo $this->Form->control('registro', ['label' => 'Registro', 'placeholder' => 'Digite o DRE', 'options' => $estudantes, 'empty' => true]);
            echo $this->Form->control('instituicao_id', ['label' => 'Mural de estágio', 'options' => $muralestagios, 'empty' => [$muralestagios_id->id => $muralestagios_id->instituicao], 'readonly' => true]);
            echo $this->Form->control('data', ['value' => date('d-m-Y'), 'readonly' => true]);
            echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $muralestagios_id->periodo, 'readonly' => true]);
            echo $this->Form->control('timestamp', ['type' => 'hidden']);
            echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => [$alunoestagio->id => $alunoestagio->nome]]);
        // die(pr($id_categoria));
        elseif (isset($user->categoria) && $user->categoria == 2):
            echo $this->Form->control('registro', ['label' => 'Registro', 'value' => $alunonovos->registro, 'readonly' => true]);
            echo $this->Form->control('instituicao_id', ['label' => 'Mural de estágio', 'options' => [$muralestagios_id->id => $muralestagios_id->instituicao], 'readonly' => true]);
            echo $this->Form->control('data', ['type' => 'hidden', 'value' => date('Y-m-d')]);
            echo $this->Form->control('periodo', ['label' => 'Período', 'options' => [$muralestagios_id->periodo => $muralestagios_id->periodo], 'readonly' => true]);
            echo $this->Form->control('timestamp', ['type' => 'hidden']);
            echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => [$alunoestagios->id => $alunoestagios->nome]]);
        else:
            $this->Flash->error(__('Inscrição não pode ser realizada'));
            echo $this->Html->link('Voltar para a lista', ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'btn btn-primary']);
        endif;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>