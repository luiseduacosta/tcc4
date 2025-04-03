<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($complemento->estagiarios);
?>

<div class="d-flex justify-content-start">
    <?php echo $this->element('menu_mural') ?>
</div>

<nav class="column">
    <div class="side-nav">
        <?= $this->Html->link(__('Listar registros'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        <?php if (isset($usser) && ($user->categoria == '1')): ?>
            <?= $this->Html->link(__('Editar registro'), ['action' => 'edit', $complemento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Excluir registro'), ['action' => 'delete', $complemento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complemento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        <?php endif; ?>
    </div>
</nav>

<div class="complementos view content">

<h3><?= h($complemento->id) ?></h3>

    <table>
        <tr>
            <th><?= __('Periodo Especial') ?></th>
            <td><?= h($complemento->periodo_especial) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($complemento->id) ?></td>
        </tr>
    </table>

    <div class="related">
        <h4><?= __('Estagiários') ?></h4>
        <?php if (!empty($complemento->estagiarios)): ?>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Id Aluno') ?></th>
                        <th><?= __('Registro') ?></th>
                        <th><?= __('Turno') ?></th>
                        <th><?= __('Nivel') ?></th>
                        <th><?= __('Tc') ?></th>
                        <th><?= __('Tc Solicitacao') ?></th>
                        <th><?= __('Instituicao') ?></th>
                        <th><?= __('Supervisor') ?></th>
                        <th><?= __('Professor') ?></th>
                        <th><?= __('Periodo') ?></th>
                        <th><?= __('Turma') ?></th>
                        <th><?= __('Nota') ?></th>
                        <th><?= __('Ch') ?></th>
                        <th><?= __('Observacoes') ?></th>
                        <th><?= __('Complemento Id') ?></th>
                        <th><?= __('Ajuste2020') ?></th>
                        <th class="row"><?= __('Ações') ?></th>
                    </tr>
                    <?php foreach ($complemento->estagiarios as $estagiarios): ?>
                        <?php // pr($estagiarios) ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= h($estagiarios->aluno_id) ?></td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <td><?= h($estagiarios->tc) ?></td>
                            <td><?= h($estagiarios->tc_solicitacao) ?></td>
                            <td><?= h($estagiarios->instituicao_id) ?></td>
                            <td><?= h($estagiarios->supervisor_id) ?></td>
                            <td><?= h($estagiarios->professor_id) ?></td>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios['turmaestagio_id']) ?></td>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td><?= h($estagiarios['complemento_id']) ?></td>
                            <td><?= h($estagiarios->ajuste2020) ?></td>
                            <td class="row">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                <?php if (isset($usser) && ($user->categoria == '1')): ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>