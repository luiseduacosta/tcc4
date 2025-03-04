<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDocentes"
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

<div class="row">
    <h3><?= __('Docentes') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentes', 'action' => 'index0'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentes', 'action' => 'index1'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentes', 'action' => 'index2'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentes', 'action' => 'index3'], ['class' => 'btn btn-primary float-end']) ?>
        <?php endif; ?>
    </p>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradoarea', "Área") ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradouniversidade', 'Universidade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradoanoconclusao', 'Conclusão') ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradoarea', "Área") ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradouniversidade', "Universidade") ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradoanoconclusao', "Conclusão") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?>
                    </td>
                    <td><?= h($docente->mestradoarea) ?></td>
                    <td><?= h($docente->mestradouniversidade) ?></td>
                    <td><?= h($docente->mestradoanoconclusao) ?></td>
                    <td><?= h($docente->doutoradoarea) ?></td>
                    <td><?= h($docente->doutoradouniversidade) ?></td>
                    <td><?= h($docente->doutoradoanoconclusao) ?></td>
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
    </div>
</div>