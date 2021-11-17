<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografia);
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Editar monografia'), ['action' => 'edit', $monografia->id], ['class' => 'button float-right']) ?> </li>
            <li><?= $this->Form->postLink(__('Excluir monografia'), ['action' => 'delete', $monografia->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $monografia->id)], ['class' => 'button float-right']) ?> </li>
        <?php endif; ?>
        <?= $this->element('menu_monografias') ?>
    </ul>
</nav>

<div class="monografias view large-9 medium-8 columns content">
    <h3><?= h($monografia->titulo) ?></h3>

    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= $this->Text->autoParagraph(h($monografia->titulo)) ?></td>
        </tr>
        <?php if (isset($monografia->resumo) && $monografia->resumo): ?>
            <tr>
                <th scope="row"colspan="2"><?= __('Resumo') ?>
            </tr>
            <tr>
                <td colspan="2"><?= $this->Text->autoParagraph(h($monografia->resumo)) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th scope="row"><?= __('Estudante') ?></th>
            <?php
            if (isset($monografia->tccestudantes) && $monografia->tccestudantes):
                echo '<td>';
                foreach ($monografia->tccestudantes as $tccestudantes):
                    echo $this->Html->link($tccestudantes->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudantes->id]);
                    echo ", ";
                endforeach;
                echo '</td>';
            endif;
            ?>
        </tr>
        <tr>
            <th scope="row"><?= __('Docente') ?></th>
            <td><?= $this->Html->link($monografia->docentemonografia->nome, ['controller' => 'docentemonografias', 'action' => 'view', $monografia->docente_id]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data') ?></th>
            <td><?= h($monografia->data) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Periodo') ?></th>
            <td><?= h($monografia->periodo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Area') ?></th>
            <td><?= $monografia->has('areamonografia') ? $this->Html->link($monografia->areamonografia->area, ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografia->id]) : "" ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Defesa') ?></th>
            <td><?= h($monografia->data_defesa) ?></td>
        </tr>
        <?php if (isset($monografia->url) && !empty($monografia->url)): ?>
            <tr>
                <th scope="row"><?= __('PDF') ?></th>
                <td><a href="<?= $baseUrl . 'monografias/' . $monografia->url ?>">Download</a></td>
            </tr>
        <?php endif; ?>
        <?php if ($monografia->co_orienta_id > 0): ?>
            <tr>
                <th scope="row"><?= __('Co Orienta Id', ['label' => 'Co-orientador']) ?></th>
                <td><?= isset($monografia->co_orienta_id) ? $this->Html->link($monografia->co_orienta_id, ['controller' => 'docentemonografias', 'action' => 'view', $monografia->co_orienta_id]) : '' ?></td>
            </tr>
        <?php endif ?>
        <tr>
            <th scope="row"><?= __('Banca1') ?></th>
            <td><?= isset($monografia->banca1) ? $monografia->docentemonografia->nome : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca2') ?></th>
            <td><?= isset($monografia->banca2) && !empty($monografia->banca2) ? $monografia->docentemonografias1->nome : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca3') ?></th>
            <td><?= isset($monografia->banca3) && !empty($monografia->banca3) ? $monografia->docentemonografias2->nome : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Convidado') ?></th>
            <td><?= h($monografia->convidado) ?></td>
        </tr>
    </table>
</div>
