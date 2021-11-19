<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
// pr($estudante);
?>
<div class="row justify-content-center">
    <?= $this->element('menu_mural'); ?>
</div>

<div class="container">

    <div class="row">
        <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $estudante->id], ['class' => 'btn btn-primary float right']) ?>
        <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
            <?= $this->Html->link(__('Listar Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float right']) ?>
            <?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float right']) ?>
            <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $estudante->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estudante->id), 'class' => 'btn btn-danger float right']) ?>
        <?php endif; ?>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#estudante" role="tab" aria-controls="home" aria-selected="true">Dados do estudante</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#inscricoes" role="tab" aria-controls="profile" aria-selected="false">Inscrições para estágio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#estagios" role="tab" aria-controls="home" aria-selected="true">Estágios cursados</a>
        </li>
    </ul>

    <div class="tab-content">

        <div id="estudante" class="tab-pane container active show">

            <h3><?= h($estudante->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $estudante->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $estudante->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($estudante->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de nascimento') ?></th>
                    <td><?= $estudante->nascimento ? date('d-m-Y', strtotime($estudante->nascimento)) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('CPF') ?></th>
                    <td><?= h($estudante->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identidade') ?></th>
                    <td><?= h($estudante->identidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Orgão') ?></th>
                    <td><?= h($estudante->orgao) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($estudante->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= $estudante->codigo_telefone ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($estudante->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= $estudante->codigo_celular ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($estudante->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('CEP') ?></th>
                    <td><?= h($estudante->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço') ?></th>
                    <td><?= h($estudante->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($estudante->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($estudante->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td><?= h($estudante->observacoes) ?></td>
                </tr>
            </table>
        </div>

        <div id="inscricoes" class="tab-pane container fade">
            <h4><?= __('Inscrições para seleção de estágio') ?></h4>
            <?php if (!empty($estudante->muralinscricoes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Mural de estágio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Período') ?></th>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                <th><?= __('Timestamp') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == 2): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($estudante->muralinscricoes as $muralinscricoes) : ?>
                            <tr>
                                <td><?= h($muralinscricoes->id) ?></td>
                                <td><?= h($muralinscricoes->id_aluno) ?></td>
                                <td><?= h($muralinscricoes->alunonovo_id) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= $muralinscricoes->has('muralestagio') ? $this->Html->link($muralinscricoes->muralestagio->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $muralinscricoes->id_instituicao]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $muralinscricoes->has('muralestagio') ? $muralinscricoes->muralestagio->instituicao : '' ?></td>
                                <?php endif; ?>
                                <td><?= date('d-m-Y', strtotime(h($muralinscricoes->data))) ?></td>
                                <td><?= h($muralinscricoes->periodo) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= h($muralinscricoes->timestamp) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                                    </td>
                                <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == 2): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div id="estagios" class="tab-pane container fade">
            <h4><?= __('Estágios cursados') ?></h4>
            <?php if (!empty($estudante->estagiarios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Instituição de estágio') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Docente') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                <th class="actions"><?= __('Actions') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($estudante->estagiarios as $estagiarios) : ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= $estagiarios->has('estudante') ? $this->Html->link(h($estagiarios->estudante->nome), ['controller' => 'estudantes', 'action' => 'view', $estagiarios->alunonovo_id]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->has('estudante') ? $estagiarios->estudante->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= $estagiarios->has('instituicaoestagio') ? $this->Html->link($estagiarios->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiarios->id_instituicao]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->has('instituicaoestagio') ? $estagiarios->instituicaoestagio->instituicao : '' ?></td>
                                <?php endif; ?>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= $estagiarios->has('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->id_supervisor]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->has('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <?php endif; ?>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= $estagiarios->has('docente') ? $this->Html->link($estagiarios->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiarios->id_professor]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->has('docente') ? $estagiarios->docente->nome : '' ?></td>
                                <?php endif; ?>

                                <td><?= $this->Number->format($estagiarios->nota, ['places' => 2]) ?></td>
                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php else: ?>
                <p>Sem estágio</p>
            <?php endif; ?>
        </div>
    </div>
</div>
