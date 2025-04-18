<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Docentes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($docentes);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentes"
            aria-controls="navbarTogglerDocentes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDocentes">
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerDocentes">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="item-link">
                    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Docentes') ?></h3>
    <div class="d-flex justify-content-end">
        <p>
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <?= $this->Html->link('Dados funcionais', ['controller' => 'Docentes', 'action' => 'index0'], ['class' => 'btn btn-secondary float-end']) ?>
                <?= $this->Html->link('Dados pessoais', ['controller' => 'Docentes', 'action' => 'index1'], ['class' => 'btn btn-secondary float-end']) ?>
                <?= $this->Html->link('Dados graduação', ['controller' => 'Docentes', 'action' => 'index2'], ['class' => 'btn btn-secondary float-end']) ?>
                <?= $this->Html->link('Dados pósgraduação', ['controller' => 'Docentes', 'action' => 'index3'], ['class' => 'btn btn-secondary float-end']) ?>
            <?php endif; ?>
        </p>
    </div>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                <th scope="col"><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                    </td>
                    <td><?= h($docente->departamento) ?></td>
                    <td><?= h($docente->homepage) ?></td>
                    <td>
                        <?php if ($docente->curriculolattes): ?>
                            <a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Lattes</a>
                        <?php endif; ?>
                    </td>
                    <td><?= h($docente->motivoegresso) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?= $this->element('templates') ?>
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
</div>