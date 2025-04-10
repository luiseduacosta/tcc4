<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
            aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerProfessor">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <li class="nav-item">
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $professor->id],
                                ['confirm' => __('Tem certeza de excluir # {0}?', $professor->id), 'class' => 'btn btn-danger float-end']
                            )
                            ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Professores'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($professor) ?>
    <fieldset>
        <legend><?= __('Editar professor(a)') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('cpf');
        echo $this->Form->control('siape');
        echo $this->Form->control('datanascimento', ['empty' => true]);
        echo $this->Form->control('localnascimento');
        echo $this->Form->control('sexo');
        echo $this->Form->control('ddd_telefone');
        echo $this->Form->control('telefone');
        echo $this->Form->control('ddd_celular');
        echo $this->Form->control('celular');
        echo $this->Form->control('email');
        echo $this->Form->control('homepage');
        echo $this->Form->control('redesocial');
        echo $this->Form->control('curriculolattes');
        echo $this->Form->control('atualizacaolattes', ['empty' => true]);
        echo $this->Form->control('curriculosigma');
        echo $this->Form->control('pesquisadordgp');
        echo $this->Form->control('formacaoprofissional');
        echo $this->Form->control('universidadedegraduacao');
        echo $this->Form->control('anoformacao');
        echo $this->Form->control('mestradoarea');
        echo $this->Form->control('mestradouniversidade');
        echo $this->Form->control('mestradoanoconclusao');
        echo $this->Form->control('doutoradoarea');
        echo $this->Form->control('doutoradouniversidade');
        echo $this->Form->control('doutoradoanoconclusao');
        echo $this->Form->control('dataingresso', ['empty' => true]);
        echo $this->Form->control('formaingresso', ['label' => ['text' => 'Forma de Ingresso'], 'options' => ['Concurso público' => 'Concurso público', 'Livre-docente' => 'Livre-docente', 'outro' => 'Outro']]);
        echo $this->Form->control('tipocargo', ['label' => ['text' => 'Tipo de Cargo'], 'options' => ['efetivo' => 'Efetivo(a)', 'substituto' => 'Substituto(a)', 'temporario' => 'Temporário(a)', 'outro' => 'Outro']]);
        echo $this->Form->control('categoria', ['label' => ['text' => 'Categoria'], 'options' => ['auxiliar' => 'Auxiliar', 'assistente' => 'Assistente', 'adjunto' => 'Adjuno', 'associado' => 'Associado', 'titular' => 'Titular', 'outro' => 'Outro']]);
        echo $this->Form->control('regimetrabalho', ['label' => ['text' => 'Regime de Trabalho'], 'options' => ['20' => '20 horas', '40' => '40 horas', '40DE' => 'Dedicação Exclusiva', 'outro' => 'Outro']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento'], 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['empty' => true]);
        echo $this->Form->control('motivoegresso');
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>