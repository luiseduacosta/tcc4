<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<!-- jQuery Mask -->
<script>
    $(document).ready(function () {
        $('#cpf').mask('000.000.000-00');
        $('#codigo-telefone').mask('00');
        $('#codigo-celular').mask('00');
        $('#telefone').mask('0000.0000');
        $('#celular').mask('00000.0000');
    });
</script>

<?= $this->element('menu_monografias') ?>
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
        /** Dados pessoais */
        echo $this->Form->control('nome', ['label' => ['text' => 'Nome']]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'pattern' => '\d{3}\.\d{3}\.\d{3}-\d{2}', 'placeholder' => '000.000.000-00', 'required' => false]);
        /** Dados funcionais */
        if (isset($siape)) {
            echo $this->Form->control('siape', ['value' => $siape, 'readonly', 'label' => ['text' => 'SIAPE']]);
        } else {
            echo $this->Form->control('siape', ['label' => ['text' => 'SIAPE']]);
        }
        echo $this->Form->control('cress', ['label' => ['text' => 'CRESS']]);
        echo $this->Form->control('regiao', ['label' => ['text' => 'Região']]);
        echo $this->Form->control('dataingresso', ['empty' => true, 'label' => ['text' => 'Data de Ingresso']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento']]);
        echo $this->Form->control('dataegresso', ['empty' => true, 'label' => ['text' => 'Data de Egresso']]);
        echo $this->Form->control('motivoegresso', ['label' => ['text' => 'Motivo de Egresso'], 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro'], 'empty' => true]);
        echo $this->Form->control('status', ['label' => ['text' => 'Status'], 'options' => ['ativo' => 'Ativo', 'inativo' => 'Inativo'], 'default' => 'ativo']);
        /** Dados de contato */
        echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'Código do Telefone']]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone']]);
        echo $this->Form->control('codigo_celular', ['label' => ['text' => 'Código do Celular']]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular']]);
        if (isset($email)) {
            echo $this->Form->control('email', ['value' => $email, 'readonly', 'label' => ['text' => 'Email']]);
        } else {
            echo $this->Form->control('email', ['label' => ['text' => 'Email']]);
        }
        /** Dados acadêmicos */
        echo $this->Form->control('curriculolattes', ['label' => ['text' => 'Currículo Lattes']]);
        echo $this->Form->control('atualizacaolattes', ['empty' => true, 'label' => ['text' => 'Atualização Lattes']]);
        /** Outras informações */
        echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => ['text' => 'Outras informações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>