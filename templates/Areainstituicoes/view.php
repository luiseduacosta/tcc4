<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="column">
    <div class="side-nav">
        <h4 class="heading"><?= __('Ações') ?></h4>
        <?= $this->Html->link(__('Editar área instituição'), ['action' => 'edit', $areainstituicao->id], ['class' => 'side-nav-item']) ?>
        <?= $this->Form->postLink(__('Excluir área instituição'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
    </div>
</nav>

<div class="column-responsive column-80">
    <div class="areainstituicoes view content">
        <h3><?= h($areainstituicao->id) ?></h3>
        <table>
            <tr>
                <th><?= __('Area') ?></th>
                <td><?= h($areainstituicao->area) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($areainstituicao->id) ?></td>
            </tr>
        </table>
    </div>
</div>

