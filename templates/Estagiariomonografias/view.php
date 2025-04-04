<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiariomonografia);
// die();
?>

<?php echo $this->element('menu_monografias'); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($estagiariomonografia->estudante->nome) ?></h3>
    <table class="table table-hover table-responsive table-striped">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $estagiariomonografia->id ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Registro') ?></th>
            <td><?= h($estagiariomonografia->registro) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Estudante') ?></th>
            <td><?= $estagiariomonografia->has('estudante') ? $this->Html->link($estagiariomonografia->estudantemonografia->nome, ['controller' => 'estudantemonografias', 'action' => 'view', $estagiariomonografia->estudantemonografia->id]) : '' ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?= __('Turno') ?></th>
            <td><?= h($estagiariomonografia->turno) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Nivel') ?></th>
            <td><?= h($estagiariomonografia->nivel) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Docente') ?></th>
            <td><?= $estagiariomonografia->has('docentemonografia') ? $this->Html->link($estagiariomonografia->docentemonografia->id, ['controller' => 'Professoresmonografia', 'action' => 'view', $estagiariomonografia->docentemonografia->id]) : '' ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?= __('Periodo') ?></th>
            <td><?= h($estagiariomonografia->periodo) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Tc') ?></th>
            <td><?= $estagiariomonografia->tc ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Tc Solicitacao') ?></th>
            <td><?= h($estagiariomonografia->tc_solicitacao) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Id Instituicao') ?></th>
            <td><?= $estagiariomonografia->id_instituicao ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Id Supervisor') ?></th>
            <td><?= $estagiariomonografia->id_supervisor ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Id Area') ?></th>
            <td><?= $estagiariomonografia->id_area ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Nota') ?></th>
            <td><?= $this->Number->format($estagiariomonografia->nota) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Ch') ?></th>
            <td><?= $this->Number->format($estagiariomonografia->ch) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Observacoes') ?></th>
            <td><?= h($estagiariomonografia->observacoes) ?></td>
        </tr>
    </table>
</div>