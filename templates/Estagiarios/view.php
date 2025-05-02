<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario->aluno);
// die();
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMural">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">

                <?= $this->Html->link(__('Inserir Estagiario'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'novotermocompromisso', '?' => ['aluno_id' => $estagiario->aluno_id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
        <?php endif; ?>

        <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '4')): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Preencher Avaliação'), ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
        <?php endif; ?>

        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Imprimir Avaliação'), ['action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Preencher Atividades'), ['controller' => 'folhadeatividades', 'action' => 'view', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Imprimir Atividades'), ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class='container col-lg-8 shadow p-3 mb-5 bg-white rounded'>

    <div class="row">
        <div class="col-auto">
            <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Inserir Estagiario'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'termodecompromisso', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            <?php endif; ?>
            <?php if (isset($user) && ($user->categoria == '1' && $user->categoria == '4')): ?>
                <?= $this->Html->link(__('Preencher Avaliação'), ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            <?php endif; ?>
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <?= $this->Html->link(__('Imprimir Avaliação'), ['action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Preencher Atividades'), ['controller' => 'folhadeatividades', 'action' => 'view', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Imprimir Atividades'), ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                <?= $this->Html->link(__('Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
            <?php endif; ?>
        </div>

        <div class="container">
            <h3><?= h($estagiario->aluno['nome']) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $estagiario->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $estagiario->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= isset($estagiario->alunos) ? $this->Html->link($estagiario->alunos['nome'], ['controller' => 'Estudantes', 'action' => 'view', $estagiario->alunos['id']]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('aluno') ? $estagiario->aluno['nome'] : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Ajuste 2020') ?></th>
                    <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                </tr>

                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($estagiario->turno) ?></td>
                </tr>

                <tr>
                    <th><?= __('Nível') ?></th>
                    <td><?= h($estagiario->nivel) ?></td>
                </tr>

                <tr>
                    <th><?= __('Instituição') ?></th>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= isset($estagiario->instituicoes) ? $this->Html->link($estagiario->instituicoes['instituicao'], ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicoes['id']]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('instituicao') ? $estagiario->instituicao['instituicao'] : '' ?>
                        </td>
                    <?php endif; ?>
                </tr>

                <tr>
                    <th><?= __('Supervisor(a)') ?></th>
                    <?php if (!empty($estagiario->supervisores['nome'])): ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= isset($estagiario->supervisores) ? $this->Html->link($estagiario->supervisores['nome'], ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisores['id']]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= $estagiario->hasValue('supervisores') ? $estagiario->supervisores['nome'] : '' ?></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td>Sem informaçao</td>
                    <?php endif; ?>
                </tr>

                <tr>
                    <th><?= __('Professor') ?></th>
                    <?php if (!empty($estagiario->professores['nome'])): ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= isset($estagiario->professores) ? $this->Html->link($estagiario->professores['nome'], ['controller' => 'Professores', 'action' => 'view', $estagiario->professores['id']]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= $estagiario->hasValue('professores') ? $estagiario->professores['nome'] : '' ?></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td>Sem informaçao</td>
                    <?php endif; ?>
                </tr>

                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($estagiario->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turm de estágio') ?></th>
                    <td><?= isset($estagiario->turmaestagios) ? $this->Html->link($estagiario->turmaestagios['area'], ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagios['id']]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('TC') ?></th>
                    <td><?= $this->Number->format($estagiario->tc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data TC') ?></th>
                    <td><?= $estagiario->tc_solicitacao ? $estagiario->tc_solicitacao : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nota') ?></th>
                    <?php if ($estagiario->nota): ?>
                        <td><?= $this->Number->format($estagiario->nota, ['places' => 2]) ?></td>
                    </tr>
                <?php else: ?>
                    <td>Sem informaçao</td>
                <?php endif; ?>
                <tr>
                    <th><?= __('CH') ?></th>
                    <td><?= $this->Number->format($estagiario->ch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td name='observacoes'><?= h($estagiario->observacoes) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>