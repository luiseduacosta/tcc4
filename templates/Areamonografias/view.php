<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_monografias') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAreamonografiaView"
        aria-controls="navbarTogglerAreamonografiaView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAreamonografiaView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar área da monografia'), ['action' => 'edit', $areamonografia->id], ['class' => 'btn btn-primary float-start']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir área da monografia'), ['action' => 'delete', $areamonografia->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areamonografia->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($areamonografia->area) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-light">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($areamonografia->id) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Area') ?></th>
                <td><?= h($areamonografia->area) ?></td>
            </tr>
    </table>
</div>

<?php // pr($areamonografia->monografias); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Monografias') ?></h4>
    <?php if (!empty($areamonografia->monografias)): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Estudante') ?></th>
                    <th scope="col"><?= __('Titulo') ?></th>
                    <th scope="col"><?= __('Periodo') ?></th>
                    <th scope="col"><?= __('Orientador') ?></th>
                </tr>
            </thead>
            <?php foreach ($areamonografia->monografias as $monografias): ?>
                <?php // pr($monografias->docente->nome); ?>
                <tr>
                    <?php if (isset($monografias->tccestudante) && count($monografias->tccestudante) > 0): ?>
                        <td>
                            <?php for ($i = 0; $i < count($monografias->tccestudante); $i++): ?>
                                <?= $this->Html->link(h($monografias->tccestudante[$i]->nome), ['controller' => 'tccestudantes', 'action' => 'view', $monografias->tccestudante[$i]->id]) ?>
                            <?php endfor; ?>
                        </td>
                    <?php endif; ?>

                    <td><?= $this->Html->link(h($monografias->titulo), ['controller' => 'monografias', 'action' => 'view', $monografias->id]) ?>
                    </td>
                    <td><?= h($monografias['periodo']) ?></td>
                     <td><?= $this->Html->link(h($monografias->docente['nome']), ['controller' => 'Professores', 'action' => 'view', $monografias->docente['id']]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php // pr($areamonografia->docentes); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Professores da área') ?></h4>
    <?php if (!empty($areamonografia->docentes)): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Docente') ?></th>
                </tr>
            </thead>
            <?php foreach ($areamonografia->docentes as $docentes): ?>
                <?php // pr($monografias);  ?>
                <tr>
                    <td><?= $this->Html->link(h($docentes['nome']), ['controller' => 'Docentes', 'action' => 'view', $docentes['id']]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>