<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($area);
// pr($areamonografia)
// die("Areas");
/**
 * @var \App\View\AppView $this
<<<<<<< HEAD
 * @var \App\Model\Entity\Areamonografia $areamonografia
=======
 * @var \App\Model\Entity\Areamonografia $area
>>>>>>> f4568cb (Fix issues)
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAreamonografiaView"
        aria-controls="navbarTogglerAreamonografiaView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAreamonografiaView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Html->link(__('Editar área da monografia'), ['action' => 'edit', $area->id], ['class' => 'btn btn-primary float-start']) ?>
            </li>
            <li class="item-link">
                <?= $this->Form->postLink(__('Excluir área da monografia'), ['action' => 'delete', $area->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $area->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <h3><?= h($area->area) ?></h3>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="row"><?= __('Area') ?></th>
                <td><?= h($area->area) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($area->id) ?></td>
            </tr>
    </table>
    <div class="row">
        <h4><?= __('Monografias') ?></h4>
        <?php if (!empty($area['monografias'])): ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= __('Estudante') ?></th>
                        <th scope="col"><?= __('Titulo') ?></th>
                        <th scope="col"><?= __('Periodo') ?></th>
                        <th scope="col"><?= __('Orientador') ?></th>
                    </tr>
                </thead>
                <?php foreach ($monografiasrelacionadas as $monografias): ?>
                    <?php // pr($monografias['estudante']); ?>
                    <tr>
                        <?php if (is_array($monografias['estudante']) && (sizeof($monografias['estudante']) > 1)): ?>
                            <td>
                                <?php for ($i = 0; $i < sizeof($monografias['estudante']); $i++): ?>
                                    <?= $this->Html->link(h($monografias['estudante'][$i]), ['controller' => 'tccestudantes', 'action' => 'view', $monografias['estudante_id'][$i]]) ?>
                                <?php endfor; ?>
                            </td>
                        <?php else: ?>
                            <td><?= $this->Html->link(h($monografias['estudante']), ['controller' => 'tccestudantes', 'action' => 'view', $monografias['estudante_id']]) ?>
                            </td>
                        <?php endif; ?>

                        <td><?= $this->Html->link(h($monografias['titulo']), ['controller' => 'monografias', 'action' => 'view', $monografias['id']]) ?>
                        </td>
                        <td><?= h($monografias['periodo']) ?></td>
                        <td><?= $this->Html->link(h($monografias['docente']), ['controller' => 'docentes', 'action' => 'view', $monografias['docente_id']]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="row">
        <h4><?= __('Docentes da área') ?></h4>
        <?php if (!empty($area['docentes'])): ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= __('Docente') ?></th>
                    </tr>
                </thead>
                <?php foreach ($area['docentes'] as $docentes): ?>
                    <?php // pr($monografias);  ?>
                    <tr>
                        <td><?= $this->Html->link(h($docentes['nome']), ['controller' => 'docentes', 'action' => 'view', $docentes['id']]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>