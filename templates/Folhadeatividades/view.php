<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAtividades">
        <?php if (isset($user) && $user->categoria == '1'): ?>
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $folhadeatividade->id],
                    ['confirm' => __('Tem certeza que quer excluir esta atividade # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger']
            )
            ?>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Lista de atividades'), ['action' => 'atividade', '?' => ['estagiario_id' => $folhadeatividade->estagiario->id]], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>        

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($folhadeatividade) ?>
        <fieldset>
            <legend><?= __('Atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['options' => [$folhadeatividade->estagiario->id => $folhadeatividade->estagiario->aluno->nome]]);
            echo $this->Form->control('dia', ['class' => 'form-control']);
            echo $this->Form->control('inicio', ['label' => 'Início', 'class' => 'form-control']);
            echo $this->Form->control('final', ['label' => 'Final', 'class' => 'form-control']);
            echo $this->Form->control('atividade', ['class' => 'form-control']);
            echo $this->Form->control('horario', ['type' => 'hidden', 'empty' => true]);
            ?>
        </fieldset>
        <div class="d-flex justify-content-center">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>