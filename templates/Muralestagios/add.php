<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMural">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar mural de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="muralestagios form content">
    <?= $this->Form->create($muralestagio, ['method' => 'post']) ?>
    <fieldset>
        <legend><?= __('Novo mural de estágio') ?></legend>
        <?php
        echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => 'Selecione']);
        echo $this->Form->control('instituicao', ['type' => 'hidden']);
        echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
        echo $this->Form->control('vagas');
        echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios']]);
        echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
        echo $this->Form->control('cargaHoraria', ['label' => ['text' => 'Carga horária']]);
        echo $this->Form->control('requisitos', ['id' => 'editor-requisitos', 'label' => ['text' => 'Requisitos']]);
        echo $this->Form->control('turmeestagio_id', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => 'Selecione']);
        echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
        echo $this->Form->control('professor_id', ['label' => ['text' => 'Docente da OTP'], 'options' => $professores, 'empty' => [0 => 'Selecione']]);
        echo $this->Form->control('dataInscricao', ['label' => ['text' => 'Encerramento das inscrições'], 'empty' => true]);
        echo $this->Form->control('dataSelecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
        echo $this->Form->control('horarioSelecao', ['label' => ['text' => 'Horário da seleção']]);
        echo $this->Form->control('localSelecao', ['label' => ['text' => 'Local da seleção']]);
        echo $this->Form->control('formaSelecao', ['label' => ['text' => 'Forma de seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras (especificar em "Outras informações")']]);
        echo $this->Form->control('contato', ['label' => ['text' => 'Contato']]);
        echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
        echo $this->Form->control('datafax', ['type' => 'hidden', 'empty' => true]);
        echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e no mural da Coordenação de Estágio/ESS']]);
        echo $this->Form->control('email');
        echo $this->Form->control('outras', ['id' => 'editor-outras', 'label' => ['text' => 'Outras informações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Initialize Quill editor -->
<script>
    const quillRequisitos = new Quill('#editor-requisitos', {
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ script: 'sub' }, { script: 'super' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ direction: 'rtl' }],
                [{ size: ['small', false, 'large', 'huge'] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ['image', 'code-block']
            ]
        },
        theme: 'snow'
    });

    const quillOutras = new Quill('#editor-outras', {
        theme: 'snow'
    });

    // Sync Quill content with textarea on form submit
    document.querySelector('form').onsubmit = function () {
        document.querySelector('textarea#editor-requisitos').value = quillRequisitos.root.innerHTML;
        document.querySelector('textarea#editor-outras').value = quillOutras.root.innerHTML;
    };
</script>