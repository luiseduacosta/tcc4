<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarTogglerMonografiasView" aria-controls="navbarTogglerMonografiasView"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMonografiasView">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Monografia'), ['action' => 'edit', $monografia->id], ['class' => 'btn btn-primary me-1']) ?>
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
                <td colspan="2"><?= $this->Text->autoParagraph($monografia->resumo) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th scope="row"><?= __('Estudante') ?></th>
            <?php
            if (isset($monografia->tccestudantes) && !empty($monografia->tccestudantes)):
                echo '<td>';
                $nomes = [];
                foreach ($monografia->tccestudantes as $tccestudante):
                    if (is_string($tccestudante->nome) && $tccestudante->nome !== '') {
                        $nomes[] = $this->Html->link($tccestudante->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudante->id]);
                    }
                endforeach;
                echo implode(', ', $nomes);
                echo '</td>';
            else:
                echo '<td></td>';
            endif;
            ?>
        </tr>
        <tr>
            <th scope="row"><?= __('Professor(a)') ?></th>
            <td><?= $monografia->hasValue('professor') && is_string($monografia->professor->nome) && $monografia->professor->nome !== '' ? $this->Html->link($monografia->professor->nome, ['controller' => 'Professores', 'action' => 'view', $monografia->professor_id]) : '' ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('Co-orientador') ?></th>
            <td><?php
                if ($monografia->hasValue('professor_coorienta') && is_string($monografia->professor_coorienta->nome) && $monografia->professor_coorienta->nome !== '') {
                    echo $this->Html->link($monografia->professor_coorienta->nome, ['controller' => 'Professores', 'action' => 'view', $monografia->num_co_orienta]);
                } else {
                    echo is_string($monografia->num_co_orienta) || is_numeric($monografia->num_co_orienta) ? h($monografia->num_co_orienta) : '';
                }
                ?>
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
            <th scope="row"><?= __('Área') ?></th>
            <td><?= $monografia->hasValue('areamonografias') && is_string($monografia->areamonografias->area) && $monografia->areamonografias->area !== '' ? $this->Html->link($monografia->areamonografias->area, ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografias->id]) : '' ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Defesa') ?></th>
            <td><?= h($monografia->data_defesa) ?></td>
        </tr>
        <?php if (!empty($monografia->url)): ?>
            <tr>
                <th scope="row"><?= __('PDF') ?></th>
                <td><a href="<?= WWW_ROOT . 'monografias/' . $monografia->url ?>">Download</a></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th scope="row"><?= __('Banca1') ?></th>
            <td><?= h($monografia->hasValue('professor_banca1') ? $monografia->professor_banca1->nome : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca2') ?></th>
            <td><?= h($monografia->hasValue('professor_banca2') ? $monografia->professor_banca2->nome : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banca3') ?></th>
            <td><?= h($monografia->hasValue('professor_banca3') ? $monografia->professor_banca3->nome : '') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Convidado(a)') ?></th>
            <td><?= h($monografia->convidado) ?></td>
        </tr>

    </table>
</div>