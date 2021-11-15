<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
// pr($alunonovos);
// pr($alunoestagios);
// die();
$categoria = $this->getRequest()->getAttribute('identity')['categoria'];
// die();
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralinscricoes form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Inscrição para seleção de estágio') ?></legend>
                <?php
                if (isset($categoria) && $categoria == 1):
                    echo $this->Form->control('id_aluno', ['label' => 'Registro', 'placeholder' => 'Digite o DRE', 'options' => $estudantes, 'empty' => true]);
                    echo $this->Form->control('id_instituicao', ['label' => 'Mural de estágio', 'options' => $muralestagios, 'empty' => [$muralestagios_id->id => $muralestagios_id->instituicao]], 'readonly');
                    echo $this->Form->control('data', ['value' => date('d-m-Y', strtotime(now())), 'readonly']);
                    echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $muralestagios_id->periodo, 'readonly']);
                    echo $this->Form->control('timestamp', ['type' => 'hidden']);
                    echo $this->Form->control('alunonovo_id', ['label' => 'Estudante', 'options' => [$alunonovos->id => $alunonovos->nome], 'value' => $alunonovos->id, 'readonly']);
                    echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => [$alunoestagio->id => $alunoestagio->nome]]);
                    // die(pr($id_categoria));
                elseif (isset($categoria) && $categoria == 2):
                    echo $this->Form->control('id_aluno', ['label' => 'Registro', 'value' => $alunonovos->registro, 'readonly']);
                    echo $this->Form->control('id_instituicao', ['label' => 'Mural de estágio', 'options' => [$muralestagios_id->id => $muralestagios_id->instituicao]], 'readonly');
                    echo $this->Form->control('data', ['type' => 'hidden', 'value' => date('Y-m-d')]);
                    echo $this->Form->control('periodo', ['label' => 'Período', 'options' => [$muralestagios_id->periodo => $muralestagios_id->periodo], 'readonly']);
                    echo $this->Form->control('timestamp', ['type' => 'hidden']);
                    echo $this->Form->control('alunonovo_id', ['label' => 'Estudante', 'options' => [$alunonovos->id => $alunonovos->nome], 'value' => $alunonovos->id, 'readonly']);
                    echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => [$alunoestagios->id => $alunoestagios->nome]]);
                else:
                    $this->Flash->error('Inscrição não pode ser realizada');
                    $this->redirect('/muralinscricoes/index');
                endif;
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
