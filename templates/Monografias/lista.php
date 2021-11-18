<?php
$user = $this->getRequest()->getAttribute('identity');

// pr($arquivospdf);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>

<div class="row justify-content-center">
    <?= $this->element('menu_monografias') ?>
</div>

<div class="monografias view large-9 medium-8 columns content">
    <h3><?= __('Monografias em PDF') ?></h3>
    <table class="vertical-table">
        <tr>
            <td>Pdf</td>
            <td>Estudante</td>
            <td>Dre</td>
        </tr>
        <?php foreach ($arquivospdf as $c_arquivopdf): ?>
            <tr>
                <td><?= $this->Html->link($c_arquivopdf['pdf'], '/monografias/' . $c_arquivopdf['pdf'] . '.pdf') ?></td>
                <td><?= $this->Html->link($c_arquivopdf['nome'], ['controller' => 'Tccestudantes', 'action' => 'view', $c_arquivopdf['id']]) ?></td>
                <td><?= $c_arquivopdf['registro'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>