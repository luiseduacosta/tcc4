<?php
$user = $this->getRequest()->getAttribute('identity');
// echo $baseUrl;
// pr($user['role']);
// pr($monografias);
// pr($files);
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMonografias"
        aria-controls="navbarTogglerMonografias" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMonografias">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova Monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container">

    <h3><?= __('Monografias') ?></h3>

    <?= $this->element('templates') ?>

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('titulo', ['label' => 'Busca por título']) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <table class='table table-striped table-hover table-responsive'>
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Monografias.titulo', 'Título') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.periodo', 'Período') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes.nome', 'Estudante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Docentes.nome', 'Orientador(a)') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Areamonografias.area', 'Área') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.url', 'PDF') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monografias as $monografia): ?>
                <?php // $titulo = $monografia->titulo; ?>
                <?php // die(pr($titulo)); ?>
                <tr>

                    <td>
                        <?=
                            $this->Html->link(substr($monografia->titulo, 0, 55) . ' ...', ['action' => 'view', $monografia->id])
                            ?>
                    </td>

                    <td><?= h($monografia->periodo) ?></td>
                    <td>
                        <?php
                        if (!(empty($monografia->tccestudantes))):
                            $q_estudantes = count($monografia->tccestudantes);
                            foreach ($monografia->tccestudantes as $tccestudantes):
                                // pr($tccestudantes);
                                echo $this->Html->link($tccestudantes->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudantes->id]);
                                if ($q_estudantes > 1):
                                    echo ", ";
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </td>
                    <td><?= $this->Html->link(h($monografia->docente->nome), ['controller' => 'docentes', 'action' => 'view', $monografia->docente->id]) ?>
                    </td>
                    <td><?= $monografia->has('areamonografia') ? $this->Html->link($monografia->areamonografia->area, ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografia->id]) : '' ?>
                    </td>
                    <?php if (!empty($monografia->url)): ?>
                        <td><a href="<?= $baseUrl . 'monografias/'. $monografia->url ?>">Download</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>