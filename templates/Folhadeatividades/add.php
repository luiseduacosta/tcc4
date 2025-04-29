<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario);
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <h4 class="heading"><?= __('Ações') ?></h4>
        <?= $this->Html->link(__('Listar Folha de atividades'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
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
