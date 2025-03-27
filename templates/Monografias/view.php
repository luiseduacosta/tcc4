<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($monografia);
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_monografias') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMonografiasView"
        aria-controls="navbarTogglerMonografiasView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMonografiasView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Monografia'), ['action' => 'edit', $monografia->id], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Monografia'), ['action' => 'delete', $monografia->id], ['confirm' => __('Tem certeza que quer excluir # {0}?', $monografia->id), 'class' => 'btn btn-danger float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($monografia->titulo) ?></h3>
    <table class="table table-striped table-hover">
        <th scope="row"><?= __('Titulo') ?></th>
        <td><?= $this->Text->autoParagraph(h($monografia->titulo)) ?></td>
        </tr>
        <?php if (isset($monografia->resumo) && $monografia->resumo): ?>
            <tr>
                <th scope="row" colspan="2"><?= __('Resumo') ?>
            </tr>
            <tr>
                <td colspan="2"><?= $this->Text->autoParagraph(h($monografia->resumo)) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th scope="row"><?= __('Estudante') ?></th>
            <?php
            if (isset($monografia->tccestudante)):
                echo '<td>';
                foreach ($monografia->tccestudante as $tccestudantes):
                    echo $this->Html->link($tccestudantes->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudantes->id]);
                    echo ", ";
                endforeach;
                echo '</td>';
            endif;
            ?>
        </tr>
        <tr>
            <th scope="row"><?= __('Professor(a)') ?></th>
            <td><?= $this->Html->link($monografia->docente['nome'], ['controller' => 'Docentes', 'action' => 'view', $monografia->professor_id]) ?>
            </td>
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
            <td><?= $monografia->has('areamonografia') ? $this->Html->link($monografia->areamonografia['area'], ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografia['id']]) : "" ?>
            </td>
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
                <td><?= $monografia->hasValue('co_orienta_id > 0') ? $this->Html->link($monografia->co_orienta_id, ['controller' => 'Professores', 'action' => 'view', $monografia->co_orienta_id]) : '' ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <th scope="row"><?= __('Banca1') ?></th>
            <td><?= h($monografia->hasValue('professorbanca1') ? $monografia->professorbanca1['nome'] : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca2') ?></th>
            <td><?= h($monografia->hasValue('professorbanca2') ? $monografia->professorbanca2['nome'] : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca3') ?></th>
            <td><?= h($monografia->hasValue('professorbanca3') ? $monografia->professorbanca3['nome'] : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Convidado(a)') ?></th>
            <td><?= h($monografia->convidado) ?></td>
        </tr>

    </table>
</div>