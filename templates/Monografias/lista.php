<?php

$user = $this->getRequest()->getAttribute('identity');

// pr($arquivospdf);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Monografias em PDF') ?></h3>
    <table class="table table-striped table-hover">

        <head class="table-dark">
            <tr>
                <th>Pdf</th>
                <th>Estudante</th>
                <th>Dre</th>
            </tr>
        </head>
        <?php foreach ($arquivospdf as $c_arquivopdf): ?>
            <tr>
                <td><?= $this->Html->link($c_arquivopdf['pdf'], '/monografias/' . $c_arquivopdf['pdf'] . '.pdf') ?></td>
                <td><?= $this->Html->link($c_arquivopdf['nome'], ['controller' => 'Tccestudantes', 'action' => 'view', $c_arquivopdf['id']]) ?>
                </td>
                <td><?= $c_arquivopdf['registro'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>