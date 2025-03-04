<?php

$user = $this->getRequest()->getAttribute('identity');
// pr($estudantes);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
?>

<script>
    function contatitulo() {
        var max = 180;
        var len = document.getElementById('titulo').value.length;
        if (len >= max) {
            alert('Você atingiu o limite de ' + max + ' caracteres');
            // document.getElementById('caraterestitulo').value = 'Você atingiu o limite de ' + max + ' caracteres';
        } else {
            var char = max - len;
            document.getElementById('caraterestitulo').value = char + ' caracteres restantes';
        }
    }

    function contaresumo() {
        var max = 7000;
        var len = document.getElementById('resumo').value.length;
        if (len >= max) {
            alert('Você atingiu o limite de ' + max + ' caracteres');
            // document.getElementById('carateresresumo').value = 'Você atingiu o limite de ' + max + ' caracteres';
        } else {
            var char = max - len;
            document.getElementById('carateresresumo').value = char + ' caracteres restantes';
        }
    }

    $(document).ready(function () {
        $('#resumo').keyup(function () {
            var max = 7000;
            var len = $(this).val().length;
            if (len >= max) {
                $('#resumo').text('Você atingiu o limite de ' + max + ' caracteres');
            } else {
                var char = max - len;
                $('#resumo').text(char + ' caracteres restantes');
            }
        });
    });
</script>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<?php $this->element('templates') ?>

<div class="row">
    <?= $this->Form->create($monografia, ['type' => 'file']) ?>
    <legend><?= __('Inserir nova monografia') ?></legend>
    <?php
    echo $this->Form->control('registro', ['options' => $estudantes, 'empty' => 'Seleciona estudante']);
    echo $this->Form->control('catalogo', ['label' => 'Catalogo', 'type' => 'hidden']);
    ?>
    <div class=" form-group row">
        <label class="col-2 control-label">Título</label>
        <div class="col-8">
            <textarea class="form-control" name="titulo" id="titulo" rows="5" maxlength="180" onkeyup="contatitulo()"
                placeholder="Digite o título com até 180 carateres"></textarea>
            <input id="caraterestitulo" />
        </div>
    </div>

    <div class=" form-group row">
        <label class="col-2 control-label">Resumo</label>
        <div class="col-8">
            <textarea class="form-control" name="resumo" id="resumo" rows="5" maxlength="7000" onkeyup="contaresumo()"
                placeholder="Digite um texto corrido, sem parágrafos"></textarea>
            <input id="carateresresumo" />
        </div>
    </div>

    <?php
    echo $this->Form->control('data_de_entrega', ['label' => 'Data de entrega', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
    echo $this->Form->control('ano', ['type' => 'year', 'minYear' => date('Y') - 20, 'maxYear' => date('Y'), 'required' => true]);
    echo $this->Form->control('semestre', ['options' => ['0' => 'Sem dados', '1' => '1º', '2' => '2º']]);
    echo $this->Form->control('docente_id', ['label' => 'Orientador(a)', 'options' => $professores, 'empty' => 'Selecione', 'required' => true]);
    echo $this->Form->control('co_orienta_id', ['label' => 'Co-orientador(a)', 'options' => $professores, 'empty' => true, 'required' => false]);
    echo $this->Form->control('areamonografia_id', ['label' => 'Área', 'options' => $areas, 'empty' => 'Seleciona área', 'required' => false]);
    echo $this->Form->control('data_banca', ['label' => 'Data da banca', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
    echo $this->Form->control('banca1', ['label' => 'Banca Professor(a) orientador', 'options' => $professores, 'empty' => 'Selecione', 'required' => true]);
    echo $this->Form->control('banca2', ['label' => 'Banca Professor(a)', 'options' => $professores, 'empty' => true]);
    echo $this->Form->control('banca3', ['label' => 'Banca Professor(a)', 'options' => $professores, 'empty' => true]);
    ?>
    <div class="form-group row">
        <label class="col-2 control-label">Convidado(a)</label>
        <div class="col-8">
            <input class="form-control" type="text" name="convidado" id="convidado" placeholder="Convidado(a)" />
        </div>
    </div>

    <div class="form-group row">
        <label class="col-2 control-label">Inserir monografia em PDF</label>
        <div class="col-8">
            <input class="form-control" type="file" name="url" id="url" />
        </div>
    </div>

    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>