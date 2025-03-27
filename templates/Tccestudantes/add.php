<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_monografias') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerTccestudantesAdd"
        aria-controls="navbarTogglerTccestudantesAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerTccestudantesAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link"><?= $this->Html->link(__('Estudantes autores'), ['action' => 'index']) ?> </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3 class="text-center"><?= __('Inserir estudante(s) autor(es) de TCC') ?></h3>
    <?= $this->Form->create($tccestudante) ?>
    <fieldset>
        <?php
        if (isset($nome) and isset($registro)):
            echo $this->Form->control('monografia_id', ['options' => $monografias, 'value' => $monografia_id, 'required' => true]);
            echo $this->Form->control('nome', ['value' => $nome, 'required' => true]);
            echo $this->Form->control('registro', ['value' => $registro, 'required' => true]);
        else:
            echo $this->Form->control('monografia_id', ['options' => $monografias, 'empty' => 'Selecione monografia', 'required' => true]);
            echo $this->Form->control('nome', ['options' => $estudantes, 'empty' => 'Selecione estudante', 'required' => true]);
            // echo $this->Form->control('registro', ['required' => true]);
        endif;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>
