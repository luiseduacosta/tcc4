<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\I18n\FrozenTime $now
 */
$user = $this->request->getAttribute('identity');
$now = new \Cake\I18n\FrozenTime();
?>

<script type="text/javascript">
    function getaluno(id) {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Alunos', 'action' => 'getaluno']) ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            },
            success: function (response) {
                if (response && Object.keys(response).length > 0) {
                    $('#registro').val(response.registro);
                    $('#turno').val(response.turno);
                    $('#nivel').val(response.nivel);
                    $('#tc').val(response.tc);
                    $('#ajuste2020').val(response.ajuste2020);
                    $('#tc_solicitacao').val(response.tc_solicitacao);
                    $('#instituicao-id').val(response.instituicao_id);
                    $('#supervisor-id').val(response.supervisor_id);
                } else {
                    $('#registro').val('');
                    $('#turno').val('');
                    $('#nivel').val('');
                    $('#tc').val('');
                    $('#ajuste2020').val('');
                    $('#tc_solicitacao').val('');
                    $('#instituicao-id').val('');
                    $('#supervisor-id').val('');
                    alert('Nenhum aluno encontrado');
                }
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
            }
        });
    }

    function getsupervisores(id) {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'buscasupervisores']) ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            },
            success: function (response) {
                let options = '<option value="">Selecione o supervisor</option>';
                if (response && Object.keys(response).length > 0) {
                    $.each(response, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                } else {
                    options = '<option value="">Nenhum supervisor encontrado</option>';
                }
                $('#supervisor-id').html(options);
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
                $('#supervisor-id').html('<option value="">Erro ao carregar supervisores</option>');
            }
        });
    }
</script>

<?php echo $this->element('menu_mural'); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstagiarioAdd"
        aria-controls="navbarTogglerEstagiarioAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerEstagiarioAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Novo estagiário') ?></legend>
        <?php
        if (isset($aluno)) {
            echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => [$aluno->id => $aluno->nome], 'readonly' => true]);
        } elseif (isset($alunos)) {
            echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => $alunos, 'empty' => ['' => 'Seleciona estudante'], 'onchange' => 'getaluno(this.value)']);
        }
        echo $this->Form->control('registro', ['label' => 'DRE', 'value' => $aluno->registro, 'type' => 'text', 'readonly' => true]);
        echo $this->Form->control('turno', ['label' => 'Turno', 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido']]);
        echo $this->Form->control('nivel', ['label' => 'Nível', 'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Não curricular'], 'value' => $nivel]);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso', 'options' => ['0' => 'Sem TC', '1' => 'Com TC']]);
        echo $this->Form->control('tc_solicitacao', ['label' => 'Solicitação de TC', 'empty' => true, 'type' => 'date', 'value' => $now->i18nFormat('dd-MM-yyyy'), 'readonly' => true]);
        echo $this->Form->control('ajuste2020', ['label' => 'Ajuste 2020', 'empty' => true, 'type' => 'select', 'options' => ['0' => 'Não', '1' => 'Sim'], 'readonly' => false]);
        echo $this->Form->control('instituicao_id', ['label' => 'Instituição', 'empty' => ['' => 'Selecione uma instituição'], 'options' => $instituicoes, 'onchange' => 'getsupervisores(this.value)']);
        echo $this->Form->control('supervisor_id', ['label' => 'Supervisor', 'options' => $supervisores, 'empty' => true]);
        echo $this->Form->control('professor_id', ['label' => 'Professor', 'options' => $professores, 'empty' => true]);
        echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo->mural_periodo_atual]);
        echo $this->Form->control('turmaestagio_id', ['label' => 'Turma de estágio', 'options' => $turmaestagios, 'empty' => true]);
        if (isset($user) && $user->categoria == '1') {
            echo $this->Form->control('nota', ['label' => 'Nota', 'value' => '', 'readonly' => true]);
            echo $this->Form->control('ch', ['label' => 'Carga horária', 'value' => '', 'readonly' => true]);
            echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => 'Observações', 'value' => '']);
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Strikethrough,
        Font,
        Paragraph,
        List,
        Alignment
    } from 'ckeditor5';

    let requisitos;
    if (typeof requisitos !== 'undefined') {
        requisitos.destroy();
    }

    ClassicEditor
        .create(document.querySelector('#observacoes'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'bulletedList', 'numberedList', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            observacoes = editor;
            console.log('Olá editor observações inicializado', observacoes);
            requisitos.setData("");
        });

</script>