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
<div class="row">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="column">
    <div class="side-nav">
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
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
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>