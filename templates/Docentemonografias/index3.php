<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>
<div class="row justify-content-center">
    <?php echo $this->element('menu_monografias'); ?>        
</div>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<?php endif; ?>

<div class="docentes index large-9 medium-8 columns content">
    <h3><?= __('Docentes') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentemonografias', 'action' => 'index0'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentemonografias', 'action' => 'index1'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentemonografias', 'action' => 'index2'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentemonografias', 'action' => 'index3'], ['class' => 'button float-right']) ?>
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
            <?php foreach ($docentemonografias as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?></td>
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
