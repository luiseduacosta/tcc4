<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
?>

<div class="d-flex justify-content-start">
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
        <?= $this->element('menu_esquerdo') ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-center">

    <?= $this->Form->create(null, ['url' => ['action' => 'busca']]) ?>
    <?= $this->Form->control('titulo', ['label' => 'Busca por título', 'value' => $this->getRequest()->getSession()->read('busca')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Monografias') ?></h3>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tccestudantes->nome', 'Estudante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome', 'Orientador(a)') ?></th>
                <th scope="col"><?= $this->Paginator->sort('area_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url', 'PDF') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monografias as $monografia): ?>
                <?php // pr($monografia->tccestudantes); ?>
                <tr>
                    <td><?= $this->Html->link(__(h($monografia->titulo)), ['action' => 'view', $monografia->id]) ?></td>
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
                    <td><?= $this->Html->link(h($monografia->docente->nome), ['controller' => 'Professores', 'action' => 'view', $monografia->docente->id]) ?>
                    </td>
                    <td><?= $monografia->has('area') ? $this->Html->link($monografia->area->area, ['controller' => 'Areas', 'action' => 'view', $monografia->area->id]) : '' ?>
                    </td>
                    <td><?= $this->Html->link($monografia->url, '/monografias/' . $monografia->url, ['download' => $monografia->url]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>