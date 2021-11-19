<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
// pr($agendamentotcc);
?>

<div class="row justify-content-center">
    <?= $this->element('menu_monografias') ?>
</div>

<div class="row">
    <div class="side-nav">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link(__('Agendar defesa'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id], ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $agendamentotcc->id), 'class' => 'btn btn-danger float-right']) ?>
        <?php endif; ?>
        <?= $this->Html->link(__('Agendamentos marcados'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Ata da Defesa'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Declarações de participção'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="container">
        <div class="agendamentotccs view container">
            <h3><?= h($agendamentotcc->estudante->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Estudante') ?></th>
                    <td><?= $agendamentotcc->has('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->estudante->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Docente') ?></th>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td><?= $agendamentotcc->has('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= $agendamentotcc->has('docente') ? $agendamentotcc->docente->nome : '' ?></td>                    
                    <?php endif; ?>
                </tr>

                <tr>
                    <th><?= __('Banca1') ?></th>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td><?= $agendamentotcc->has('docentes1') ? $this->Html->link($agendamentotcc->docentes1->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes1->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= $agendamentotcc->has('docentes1') ? $agendamentotcc->docentes1->nome : '' ?></td>                    
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Banca2') ?></th>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td><?= $agendamentotcc->has('docentes2') ? $this->Html->link($agendamentotcc->docentes2->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes2->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= $agendamentotcc->has('docentes2') ? $agendamentotcc->docentes2->nome : '' ?></td>                    
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Convidado') ?></th>
                    <td><?= h($agendamentotcc->convidado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($agendamentotcc->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sala') ?></th>
                    <td><?= h($agendamentotcc->sala) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($agendamentotcc->data->format('d-m-Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Horario') ?></th>
                    <td><?= h($agendamentotcc->horario->i18nFormat('HH:mm:ss')) ?></td>
                </tr>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <tr>
                        <th><?= __('Avaliacao') ?></th>
                        <td><?= h($agendamentotcc->avaliacao) ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
