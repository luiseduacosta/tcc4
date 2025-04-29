<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario);
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAtividades">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar atividades'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($folhadeatividade) ?>
        <fieldset>
            <legend><?= __('Adicionar atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->estudante->nome], 'readonly']);
            echo $this->Form->control('dia');
            ?>
            <table class="table table-bordered">
                <tr>
                    <td>
                        <?= __('Horário de início') ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('inicio', ['label' => false, 'class' => 'form-control']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= __('Horário de finalização') ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('final', ['label' => false, 'class' => 'form-control']); ?>
                    </td>
                </tr>
            </table>
            <?php echo $this->Form->control('atividade', ['class' => 'form-control']); ?>
            <?php echo $this->Form->control('horario', ['type' => 'hidden']); ?>
        </fieldset>
        <div class="d-flex justify-content-end">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>
