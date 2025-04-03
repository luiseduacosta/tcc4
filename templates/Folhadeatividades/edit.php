<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario);
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <nav class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Açoes') ?></h4>
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $folhadeatividade->id],
                        ['confirm' => __('Tem certeza que quer excluir esta atividade # {0}?', $folhadeatividade->id), 'class' => 'side-nav-item']
                )
                ?>
                <?= $this->Html->link(__('Lista de atividades'), ['action' => 'index', $estagiario->estagiario->id], ['class' => 'side-nav-item']) ?>
            </div>
        </nav>
        <div class="column-responsive column-80">
            <div class="folhadeatividades form content">
                <?= $this->Form->create($folhadeatividade) ?>
                <fieldset>
                    <legend><?= __('Edita atividade') ?></legend>
                    <?php
                    echo $this->Form->control('estagiario_id', ['options' => [$estagiario->estagiario->id => $estagiario->estagiario->estudante->nome]]);
                    echo $this->Form->control('dia');
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>";
                    echo "Horário de início";
                    echo "</td>";
                    echo "<td>";
                    echo $this->Form->control('inicio', ['label' => False]);
                    echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>";
                    echo "Horário de finalização";
                    echo "</td>";
                    echo "<td>";

                    echo $this->Form->control('final', ['label' => False]);
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";

                    echo $this->Form->control('horario', ['type' => 'hidden', 'empty' => true]);
                    echo $this->Form->control('atividade');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>