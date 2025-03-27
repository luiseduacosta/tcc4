<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($alunos);
?>

<script>
    function contatitulo() {
        var max = 180;
        var len = document.getElementById('titulo').value.length;
        if (len >= max) {
            alert('Você atingiu o limite de ' + max + ' caracteres');
        } else {
            var char = max - len;
            document.getElementById('caraterestitulo').value = char + ' caracteres restantes';
        }
    }
</script>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_monografias') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAgendamentosAdd"
        aria-controls="navbarTogglerAgendamentosAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAgendamentosAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Agendamentos de Tcc'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($agendamentotcc) ?>
    <fieldset class="border p-2">
        <legend><?= __('Agendamento de oficina de defesa de TCC') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['label' => 'Estudante', 'options' => $alunos, 'empty' => 'Seleciona']);
        echo $this->Form->control('professor_id', ['label' => 'Professor(a)', 'options' => $professores, 'empty' => 'Seleciona']);
        echo $this->Form->control('banca1', ['label' => 'Banca', 'options' => $professores, 'empty' => 'Seleciona']);
        echo $this->Form->control('banca2', ['label' => 'Banca', 'options' => $professores, 'empty' => 'Seleciona']);
        echo $this->Form->control('convidado', ['label' => 'Convidado(a)']);
        echo $this->Form->control('data', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']]);
        echo $this->Form->control('horario', ['type' => 'time', 'templates' => ['dateWidget' => '{{HH}}{{mm}}{{ss}}']]);
        echo $this->Form->control('sala', ['label' => 'Sala. Colocar 0 se for não-presencial', 'default' => '0']);
        ?>
        <div class=" form-group row">
            <label class="col-2 control-label">Título</label>
            <div class="col-8">
                <textarea class="form-control" name="titulo" id="titulo" rows="5" maxlength="180"
                    onkeyup="contatitulo()" placeholder="Digite o título com até 180 carateres"></textarea>
                <input id="caraterestitulo" />
            </div>
        </div>
        <?php
        echo $this->Form->control('avaliacao', ['type' => 'hidden', 'value' => 's/d']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>