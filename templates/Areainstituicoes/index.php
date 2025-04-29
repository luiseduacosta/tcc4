<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao[]|\Cake\Collection\CollectionInterface $areainstituicoes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user) && $user->categoria = '1') ?>
                <li class='nav-link'>
                    <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            <?php endif; ?>
            </ul>
        </div>        
    </div>
</nav>

<h3><?= __('Área instituicoes') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class='table table-responsive table-hover table-striped'>
        <thead class='table-dark'>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('area') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areainstituicoes as $areainstituicao): ?>
                <tr>
                    <td><?= $areainstituicao->id ?></td>
                    <td><?= h($areainstituicao->area) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $areainstituicao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $areainstituicao->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
        <?= $this->Paginator->prev('< ' . __('anterior')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('próximo') . ' >') ?>
        <?= $this->Paginator->last(__('último') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?></p>
</div>
