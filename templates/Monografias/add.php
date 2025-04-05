<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estudantes);
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
</script>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMonografiasAdd"
            aria-controls="navbarTogglerMonografiasAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMonografiasAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Monografias'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
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
    echo $this->Form->control('ano', ['type' => 'year', 'min' => date('Y') - 20, 'max' => date('Y') + 10, 'required' => true]);
    echo $this->Form->control('semestre', ['options' => ['0' => 'Sem dados', '1' => '1º', '2' => '2º']]);
    echo $this->Form->control('professor_id', ['label' => 'Orientador(a)', 'options' => $docentes, 'empty' => 'Selecione', 'required' => true]);
    echo $this->Form->control('co_orienta_id', ['label' => 'Co-orientador(a)', 'options' => $docentes, 'empty' => true, 'required' => false]);
    echo $this->Form->control('areamonografia_id', ['label' => 'Área', 'options' => $areas, 'empty' => 'Seleciona área', 'required' => false]);
    echo $this->Form->control('data_banca', ['label' => 'Data da banca', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
    echo $this->Form->control('banca1', ['label' => 'Banca Professor(a) orientador', 'options' => $docentes, 'empty' => 'Selecione', 'required' => true]);
    echo $this->Form->control('banca2', ['label' => 'Banca Professor(a)', 'options' => $docentes, 'empty' => true]);
    echo $this->Form->control('banca3', ['label' => 'Banca Professor(a)', 'options' => $docentes, 'empty' => true]);
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