<?php

$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#aluno-id").change(function () {
            var aluno_id = $(this).val();
            /* $("#registro").val(aluno_id); */
            /* alert(aluno_id); */

            $.ajax({
                type: 'post',
                url: 'registro/' + aluno_id,
                data: 'aluno_id',
                dataType: 'json',
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                }, // Add this line
                success: function (resposta) {
                    // console.log(resposta);
                    $.each(resposta, function(key, item) {
                        // console.log(item);
                        // alert(item);
                        $('#registro').val(item);
                    })
                }
            });


        });
    });
</script>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?= $this->element('menu_monografias') ?>
    </ul>
</nav>
<div class="estagiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($estagiariomonografia) ?>
    <fieldset>
        <legend><?= __('Estagiario') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => 'Seleciona estudante']);
        echo $this->Form->control('registro');
        echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido']]);
        echo $this->Form->control('nivel', ['options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4]]);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso', 'options' => ['0' => 'Sem TC', '1' => 'Com TC']]);
        echo $this->Form->control('tc_solicitacao', ['empty' => true]);
        echo $this->Form->control('instituicao_id');
        echo $this->Form->control('supervisor_id');
        echo $this->Form->control('docente_id', ['options' => $docentes, 'empty' => true]);
        $digito = ((date('m')) > 6) ? '-2' : '-1';
        echo $this->Form->control('periodo', ['value' => date('Y') . $digito]);
        echo $this->Form->control('id_area', ['label' => 'Área de estágio']);
        echo $this->Form->control('nota');
        echo $this->Form->control('ch', ['label' => 'Carga horária']);
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
