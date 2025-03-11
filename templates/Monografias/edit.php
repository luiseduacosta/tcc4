<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografia->titulo);
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

</script>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMonografiasEdit"
        aria-controls="navbarTogglerMonografiasEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMonografiasEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li>
                <?=
                    $this->Form->postLink(
                        __('Excluir Monografia'),
                        ['action' => 'delete', $monografia->id],
                        ['confirm' => __('Tem certeza que quer excluir a monografia # {0}?', $monografia->id), 'class' => 'btn btn-danger float-end']
                    )
                    ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element('templates'); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($monografia, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Editar monografia') ?></legend>
        <?php
        echo $this->Form->control('catalogo', ['type' => 'hidden']);
        ?>

        <div class="form-group row">
            <label class="col-2 control-label">Título</label>
            <div class="col-8">
                <textarea class="form-control" name="titulo" id="titulo" rows="5" maxlength="180"
                    onkeyup="contatitulo()"
                    placeholder="Título de até 180 carateres"><?= $monografia->titulo ?></textarea>
                <input id="caraterestitulo" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 control-label">Resumo</label>
            <div class="col-8">
                <textarea class="form-control" name="resumo" id="resumo" rows="5" maxlength="7000"
                    onkeyup="contaresumo()"
                    placeholder="Texto corrido, sem parágrafos"><?= $monografia->resumo ?></textarea>
                <input id="carateresresumo" />
            </div>
        </div>

        <?php
        echo $this->Form->control('data ', ['label' => 'Data', 'type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}'], 'empty' => TRUE]);
        echo $this->Form->control('periodo');
        echo $this->Form->control('professor_id', ['options' => $professores, 'empty' => 'Seleciona docente']);
        echo $this->Form->control('co_orienta_id', ['label' => 'Co-orientador']);
        echo $this->Form->control('areamonografia_id', ['options' => $areas, 'empty' => 'Seleciona área']);
        echo $this->Form->control('data_defesa', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}'], 'empty' => TRUE]);
        echo $this->Form->control('banca1', ['value' => $monografia->professor_id, 'options' => $professores, 'empty' => true]);
        echo $this->Form->control('banca2', ['options' => $professores, 'empty' => true]);
        echo $this->Form->control('banca3', ['options' => $professores, 'empty' => true]);
        echo $this->Form->control('convidado');
        if (!empty($monografia['url'])):
            ?>
            <div class="form-group row">
                <label class="col-2 control-label">PDF atual</label>
                <div class="col-8">
                    <input class="form-control" type="url" name="url_atual" value="<?= $monografia['url'] ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label">PDF novo</label>
                <div class="col-8">
                    <input class="form-control" type="url" name="url" value="<?= $monografia['url'] ?>" />
                </div>
            </div>

            <?php
        else:
            ?>

            <div class="form-group row">
                <label class="col-2 control-label">PDF novo</label>
                <div class="col-8">
                    <input class="form-control" type="file" name="url" id="url" />
                </div>
            </div>

            <?php
        endif;
        ?>

        <?php
        echo $this->Form->control('timestamp', ['type' => 'hidden']);
        ?>

    </fieldset>

    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>