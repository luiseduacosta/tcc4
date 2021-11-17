<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
// pr($ultimoestagio);
// pr($atualizar);
// die();
?>

<?php echo $this->element('menu_mural') ?>
<?php if (isset($estudanteestagiario) && $estudanteestagiario): ?>
    <div class="container">
        <h3><?= __('Estágios cursados') ?></h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('Alunos.nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                        <th><?= $this->Paginator->sort('registro') ?></th>
                        <th><?= $this->Paginator->sort('ajuste2020', 'Ajuste 2020') ?></th>
                        <th><?= $this->Paginator->sort('turno') ?></th>
                        <th><?= $this->Paginator->sort('nivel') ?></th>
                        <th><?= $this->Paginator->sort('tc') ?></th>
                        <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                        <th><?= $this->Paginator->sort('Instituicaoestagios.instituicao', 'Instituicao') ?></th>
                        <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                        <th><?= $this->Paginator->sort('Docentes.nome', 'Professor/a') ?></th>
                        <th><?= $this->Paginator->sort('periodo') ?></th>
                        <th><?= $this->Paginator->sort('tipo_de_estagio') ?></th>
                        <th><?= $this->Paginator->sort('Areaestagio.area', 'Área') ?></th>
                        <th><?= $this->Paginator->sort('nota') ?></th>
                        <th><?= $this->Paginator->sort('ch', 'CH') ?></th>
                        <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                        <th class="actions"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudanteestagiario as $estagiario): ?>
                        <?php // pr($estagiario); ?>
                        <tr>
                            <?php // pr($estagiario); ?>
                            <td><?= $estagiario->id ?></td>
                            <td><?= $estagiario->has('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                            <td><?= $estagiario->has('estudante') ? $this->Html->link($estagiario->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $estagiario->alunonovo_id]) : '' ?></td>
                            <td><?= $estagiario->registro ?></td>
                            <td><?= ($estagiario->ajuste2020 == 0) ? 'Não' : 'Sim' ?></td>
                            <td><?= h($estagiario->turno) ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= $estagiario->tc ?></td>
                            <td><?= $estagiario->tc_solicitacao ? date('d-m-Y', strtotime(h($estagiario->tc_solicitacao))) : '' ?></td>
                            <td><?= $estagiario->has('instituicaoestagio') ? $this->Html->link($estagiario->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiario->instituicaoestagio->id]) : '' ?></td>
                            <td><?= $estagiario->has('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id, 'empty' => 'Seleciona']) : '' ?></td>
                            <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?></td>
                            <td><?= h($estagiario->periodo) ?></td>
                            <td><?= h($estagiario->tipo_de_estagio) ?></td>
                            <td><?= $estagiario->has('areaestagio') ? $this->Html->link($estagiario->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $estagiario->id_area]) : '' ?></td>
                            <td><?= $this->Number->format($estagiario->nota, ['places' => 2]) ?></td>
                            <td><?= $this->Number->format($estagiario->ch) ?></td>
                            <td><?= h($estagiario->observacoes) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id)]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if ($estudantes): ?>
    <div class="row">
        <div class="container">
            <div class="estagiarios form content">
                <?= $this->Form->create(null, ['type' => 'post']) ?>
                <fieldset>
                    <legend><?= __('Solicitação de termo de compromisso') ?></legend>
                    <?php
                    if (isset($atualizar)) {
                        echo $this->Form->control('id', ['value' => $ultimoestagio->id, 'readonly']);
                    }
                    // Estudante estagiário
                    if (isset($ultimoestagio) && $ultimoestagio):
                        echo "<fieldset>";
                        echo "<legend>Estagiário</legend>";
                        echo $this->Form->control('registro', ['value' => $ultimoestagio->estudante->registro, 'readonly']);
                        echo $this->Form->control('alunonovo_id', ['label' => ['text' => 'Estudante'], 'options' => [$ultimoestagio->estudante->id => $ultimoestagio->estudante->nome], 'empty' => false, 'readonly']);
                        echo $this->Form->control('id_aluno', ['label' => ['text' => 'Aluno'], 'options' => [$ultimoestagio->aluno->id => $ultimoestagio->aluno->nome], 'readonly']);
                        echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                        echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => $ultimoestagio->estudante->turno]);
                        echo $this->Form->control('nivel', ['value' => $ultimoestagio->nivel]);
                        echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
                        echo "</fieldset>";
                    // Estudante novo sem estágio
                    else:
                        echo "<fieldset>";
                        echo "<legend>Sem estágio</legend>";
                        echo $this->Form->control('registro', ['value' => $estudante_semestagio->registro, 'readonly']);
                        echo $this->Form->control('alunonovo_id', ['label' => ['text' => 'Estudante'], 'options' => [$estudante_semestagio->id => $estudante_semestagio->nome], 'empty' => false, 'readonly']);
                        // echo $this->Form->control('id_aluno', ['label' => ['text' => 'Aluno'], 'options' => [$alunos], 'readonly']);
                        echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                        echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'default' => 'I']);
                        echo $this->Form->control('nivel', ['value' => 1]);
                        echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
                        echo "</fieldset>";
                    endif;
                    echo $this->Form->control('tc', ['label' => ['text' => 'TC'], 'value' => 1, 'readonly']);
                    echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data TC'], 'value' => date('Y-m-d'), 'readonly']);
                    echo $this->Form->control('tipo_de_estagio', ['label' => ['text' => 'Tipo de estágio'], 'options' => ['1' => 'Presencial', '2' => 'Remoto'], 'default' => '1']);
                    if (isset($ultimoestagio->instituicaoestagio->id) && $ultimoestagio->instituicaoestagio->id):
                        echo $this->Form->control('id_instituicao', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => [$ultimoestagio->instituicaoestagio->id => $ultimoestagio->instituicaoestagio->instituicao]]);
                    else:
                        echo $this->Form->control('id_instituicao', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => ['Seleciona instituição de estágio']]);
                    endif;
                    if (isset($ultimoestagio->supervisor->id) && $ultimoestagio->supervisor->id):
                        echo $this->Form->control('id_supervisor', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'value' => $ultimoestagio->supervisor->id, 'empty' => true]);
                    // echo $this->Form->control('id_supervisor', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => [$ultimoestagio->supervisor->id => $ultimoestagio->supervisor->nome]]);
                    else:
                        if (isset($supervisoresdainstituicao)):
                            echo $this->Form->control('id_supervisor', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'empty' => true]);
                        else:
                            echo $this->Form->control('id_supervisor', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => true]);
                        endif;
                    endif;
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?php endif; ?>
