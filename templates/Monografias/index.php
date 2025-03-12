<?php
$user = $this->getRequest()->getAttribute('identity');

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
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Monografias') ?></h3>

    <form method="post" action="index">
        <div class="row p-3">
            <div class="col-8">
                <label class="control-label" for="text">Busca por título</label>
                <input type="text" class="form-control" id="titulo" placeholder="Título" name="titulo">
            </div>
            <input class="form-control" type="hidden" name="_csrfToken" autocomplete="off"
                value="127scuEDYV6mFZKHdCMtq8ysSpftj5HtaLy9O5qBTAs0g6jtb+Nes+lPFE7/wQq2lLx9CQ4jnfpwLFQoWctlx/drBeYxN1hU+Jh88t2+pNgN2ogLo7QvPgKxmNkK2maL2SonLJv2OIOg3Ug+bBKoyQ==">
            <div class="col-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Confirma</button>
            </div>
        </div>
    </form>

    <table class='table table-striped table-hover table-responsive'>
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Monografias.titulo', 'Título') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.periodo', 'Período') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes.nome', 'Estudante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Professores.nome', 'Orientador(a)') ?></th>
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
                    <td><?= $this->Html->link(h($monografia->professor->nome), ['controller' => 'Professores', 'action' => 'view', $monografia->professor->id]) ?>
                    </td>
                    <td><?= $monografia->has('areamonografia') ? $this->Html->link($monografia->areamonografia->area, ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografia->id]) : '' ?>
                    </td>
                    <?php if (!empty($monografia->url)): ?>
                        <td><a href="<?= $baseUrl . 'monografias/' . $monografia->url ?>">Download</a></td>
                    <?php endif; ?>
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