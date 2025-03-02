<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($area);
// pr($areamonografia)
// die("Areas");
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?= $this->Html->link(__('Edit Area'), ['action' => 'edit', $area->id]) ?> </li>
            <li><?= $this->Form->postLink(__('Delete Area'), ['action' => 'delete', $area->id], ['confirm' => __('Are you sure you want to delete # {0}?', $area->id)]) ?> </li>
        <?php endif; ?>
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>
<div class="areas view large-9 medium-8 columns content">
    <h3><?= h($area->area) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Area') ?></th>
            <td><?= h($area->area) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($area->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Monografias') ?></h4>
        <?php if (!empty($area['monografias'])): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= __('Estudante') ?></th>
                    <th scope="col"><?= __('Titulo') ?></th>
                    <th scope="col"><?= __('Periodo') ?></th>
                    <th scope="col"><?= __('Orientador') ?></th>
                </tr>
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
                            <td><?= $this->Html->link(h($monografias['estudante']), ['controller' => 'tccestudantes', 'action' => 'view', $monografias['estudante_id']]) ?></td>
                        <?php endif; ?>

                        <td><?= $this->Html->link(h($monografias['titulo']), ['controller' => 'monografias', 'action' => 'view', $monografias['id']]) ?></td>
                        <td><?= h($monografias['periodo']) ?></td>
                        <td><?= $this->Html->link(h($monografias['docente']), ['controller' => 'docentes', 'action' => 'view', $monografias['docente_id']]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Docentes') ?></h4>
        <?php if (!empty($area['docentes'])): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= __('Docente') ?></th>
                </tr>
                <?php foreach ($area['docentes'] as $docentes): ?>
                    <?php // pr($monografias);  ?>
                    <tr>
                        <td><?= $this->Html->link(h($docentes['nome']), ['controller' => 'docentes', 'action' => 'view', $docentes['id']]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
