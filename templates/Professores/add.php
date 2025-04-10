<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
            aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerProfessor">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Professore(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($professor) ?>
    <fieldset>
        <legend><?= __('Novo(a) professor(a)') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF']]);
        if (isset($siape)) {
            echo $this->Form->control('siape', ['value' => $siape, 'readonly']);
        } else {
            echo $this->Form->control('siape', ['required']);
        }
        echo $this->Form->control('datanascimento', ['empty' => true, 'label' => ['text' => 'Data de Nascimento']]);
        echo $this->Form->control('localnascimento', ['label' => ['text' => 'Local de Nascimento']]);
        echo $this->Form->control('sexo', ['options' => ['0' => 'Feminino', '1' => 'Masculino'], 'default' => '0']);
        echo $this->Form->control('ddd_telefone');
        echo $this->Form->control('telefone');
        echo $this->Form->control('ddd_celular');
        echo $this->Form->control('celular');
        if (isset($email)) {
            echo $this->Form->control('email', ['value' => $email, 'readonly']);
        } else {
            echo $this->Form->control('email', ['required']);
        }
        echo $this->Form->control('homepage');
        echo $this->Form->control('redesocial');
        echo $this->Form->control('curriculolattes', ['label' => ['text' => 'Currículo Lattes']]);
        echo $this->Form->control('atualizacaolattes', ['empty' => true, 'label' => ['text' => 'Atualização Lattes']]);
        echo $this->Form->control('curriculosigma', ['label' => ['text' => 'Currículo Sigma']]);
        echo $this->Form->control('pesquisadordgp', ['label' => ['text' => 'Pesquisador DGP']]);
        echo $this->Form->control('formacaoprofissional', ['label' => ['text' => 'Formação Profissional']]);
        echo $this->Form->control('universidadedegraduacao', ['label' => ['text' => 'Universidade de Graduação']]);
        echo $this->Form->control('anoformacao', ['label' => ['text' => 'Ano de Formação']]);
        echo $this->Form->control('mestradoarea', ['label' => ['text' => 'Área de Mestrado']]);
        echo $this->Form->control('mestradouniversidade', ['label' => ['text' => 'Universidade de Mestrado']]);
        echo $this->Form->control('mestradoanoconclusao', ['label' => ['text' => 'Ano de Conclusão do Mestrado']]);
        echo $this->Form->control('doutoradoarea', ['label' => ['text' => 'Área de Doutorado']]);
        echo $this->Form->control('doutoradouniversidade', ['label' => ['text' => 'Universidade de Doutorado']]);
        echo $this->Form->control('doutoradoanoconclusao', ['label' => ['text' => 'Ano de Conclusão do Doutorado']]);
        echo $this->Form->control('dataingresso', ['empty' => true, 'label' => ['text' => 'Data de Ingresso']]);
        echo $this->Form->control('formaingresso', ['label' => ['text' => 'Forma de Ingresso'], 'options' => ['Concurso público' => 'Concurso público', 'Livre-docente' => 'Livre-docente', 'outro' => 'Outro']]);
        echo $this->Form->control('tipocargo', ['label' => ['text' => 'Tipo de Cargo'], 'options' => ['efetivo' => 'Efetivo(a)', 'substituto' => 'Substituto(a)', 'temporario' => 'Temporário(a)', 'outro' => 'Outro']]);
        echo $this->Form->control('categoria', ['label' => ['text' => 'Categoria'], 'options' => ['auxiliar' => 'Auxiliar' , 'assistente' => 'Assistente', 'adjunto' => 'Adjuno', 'associado' => 'Associado', 'titular' => 'Titular', 'outro' => 'Outro']]);
        echo $this->Form->control('regimetrabalho', ['label' => ['text' => 'Regime de Trabalho'], 'options' => ['20' => '20 horas', '40' => '40 horas', '40DE' => 'Dedicação Exclusiva', 'outro' => 'Outro']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento'], 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['empty' => true, 'label' => ['text' => 'Data de Egresso']]);
        echo $this->Form->control('motivoegresso', ['label' => ['text' => 'Motivo de Egresso']]);
        echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => ['text' => 'Observações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>