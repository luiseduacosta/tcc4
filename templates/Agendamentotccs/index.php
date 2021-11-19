<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
// pr($agendamentotccs);
?>
<div class="row justify-content-center">
    <?php echo $this->element('menu_monografias'); ?>
</div>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Novo agendamento de TCC'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
<?php endif; ?>

<div class="agendamentotccs index content container">
    <h3><?= __('Defesas de TCC') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                    <th><?= $this->Paginator->sort('Docentes.nome', 'Orientador') ?></th>
                    <th><?= $this->Paginator->sort('Docentes1.nome', 'Banca 1') ?></th>
                    <th><?= $this->Paginator->sort('Docentes2.nome', 'Banca 2') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('horario') ?></th>
                    <th><?= $this->Paginator->sort('sala') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <th><?= $this->Paginator->sort('avaliacao') ?></th>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                    <tr>
                        <td><?= $agendamentotcc->has('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Agendamentotccs', 'action' => 'view', $agendamentotcc->id]) : '' ?></td>

                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <td><?= $agendamentotcc->has('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentemonografias', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $agendamentotcc->has('docente') ? $agendamentotcc->docente->nome : '' ?></td>
                        <?php endif; ?>

                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <td><?= $agendamentotcc->has('docentes1') ? $this->Html->link($agendamentotcc->docentes1->nome, ['controller' => 'Docentemonografias', 'action' => 'view', $agendamentotcc->docentes1->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $agendamentotcc->has('docentes1') ? $agendamentotcc->docentes1->nome : '' ?></td>
                        <?php endif; ?>

                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <td><?= $agendamentotcc->has('docentes2') ? $this->Html->link($agendamentotcc->docentes2->nome, ['controller' => 'Docentemonografias', 'action' => 'view', $agendamentotcc->docentes2->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $agendamentotcc->has('docentes2') ? $agendamentotcc->docentes2->nome : '' ?></td>                            
                        <?php endif; ?>
                            
                        <td><?= h($agendamentotcc->data->format('d-m-Y')) ?></td>
                        <td><?= h($agendamentotcc->horario->i18nFormat('HH:mm:ss')) ?></td>

                        <td><?= $this->Number->format($agendamentotcc->sala) ?></td>

                        <td><?= h($agendamentotcc->titulo) ?></td>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <td><?= h($agendamentotcc->avaliacao) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $agendamentotcc->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $agendamentotcc->id)]) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>