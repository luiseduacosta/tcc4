<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
// pr($agendamentotcc);
?>
<div class="row">
    <aside class="large-3 medium-4 columns">
        <div class="side-nav">
            <h4 class="heading"><?= __('Ações') ?></h4>
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <?= $this->Html->link(__('Agendar defesa'), ['action' => 'add'], ['class' => 'button float-right']) ?>
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id], ['class' => 'button float-right']) ?>
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agendamentotcc->id)], ['class' => 'button float-right']) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('Agendamentos marcados'), ['action' => 'index'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link(__('Ata da Defesa'), ['action' => 'index'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link(__('Declarações de participção'), ['action' => 'index'], ['class' => 'button float-right']) ?>
            <?= $this->element('menu_monografias') ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="agendamentotccs view content">
            <h3><?= h($agendamentotcc->estudante->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $agendamentotcc->has('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->estudante->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Docente') ?></th>
                    <td><?= $agendamentotcc->has('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Banca1') ?></th>
                    <td><?= $agendamentotcc->has('docentes1') ? $this->Html->link($agendamentotcc->docentes1->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes1->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Banca2') ?></th>
                    <td><?= $agendamentotcc->has('docentes2') ? $this->Html->link($agendamentotcc->docentes2->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentes2->id]) : '' ?></td>
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
                <tr>
                    <th><?= __('Avaliacao') ?></th>
                    <td><?= h($agendamentotcc->avaliacao) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
