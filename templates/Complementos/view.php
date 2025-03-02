<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?= $this->Html->link(__('Editar registro'), ['action' => 'edit', $complemento->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Excluir registro'), ['action' => 'delete', $complemento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complemento->id), 'class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Listar registros'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
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
                    <?php if (!empty($complemento->estagiarios)) : ?>
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
                                    <th><?= __('Id Instituicao') ?></th>
                                    <th><?= __('Id Supervisor') ?></th>
                                    <th><?= __('Id Professor') ?></th>
                                    <th><?= __('Periodo') ?></th>
                                    <th><?= __('Id Area') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('Ch') ?></th>
                                    <th><?= __('Observacoes') ?></th>
                                    <th><?= __('Complemento Id') ?></th>
                                    <th><?= __('Alunonovo Id') ?></th>
                                    <th><?= __('Ajuste2020') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($complemento->estagiarios as $estagiarios) : ?>
                                    <tr>
                                        <td><?= h($estagiarios->id) ?></td>
                                        <td><?= h($estagiarios->id_aluno) ?></td>
                                        <td><?= h($estagiarios->registro) ?></td>
                                        <td><?= h($estagiarios->turno) ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= h($estagiarios->tc) ?></td>
                                        <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                        <td><?= h($estagiarios->id_instituicao) ?></td>
                                        <td><?= h($estagiarios->id_supervisor) ?></td>
                                        <td><?= h($estagiarios->id_professor) ?></td>
                                        <td><?= h($estagiarios->periodo) ?></td>
                                        <td><?= h($estagiarios->id_area) ?></td>
                                        <td><?= h($estagiarios->nota) ?></td>
                                        <td><?= h($estagiarios->ch) ?></td>
                                        <td><?= h($estagiarios->observacoes) ?></td>
                                        <td><?= h($estagiarios->complemento_id) ?></td>
                                        <td><?= h($estagiarios->alunonovo_id) ?></td>
                                        <td><?= h($estagiarios->ajuste2020) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>