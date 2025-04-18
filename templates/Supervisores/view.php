<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerSupervisores"
        aria-controls="navbarTogglerSupervisores" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerSupervisores">
        <?= $this->Html->link(__('Listar supervisores(as)'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?php if (isset($user) && $user['categoria'] == 1): ?>
            <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cadastrar supervisor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->postLink(__('Exclur supervisor(a)'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#supervisora" role="tab" aria-controls="supervisora"
                aria-selected="true">Supervisora</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="instituicao"
                aria-selected="false">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                aria-selected="false">Estagiários</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="tab-content">

        <div id="supervisora" class="tab-pane container active show">
            <h3><?= h($supervisor->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $supervisor->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Cress') ?></th>
                    <td><?= $supervisor->cress ?></td>
                </tr>
                <tr>
                    <th><?= __('Regiao') ?></th>
                    <td><?= $this->Number->format($supervisor->regiao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($supervisor->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('CPF') ?></th>
                    <td><?= h($supervisor->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cargo na instituição') ?></th>
                    <td><?= h($supervisor->cargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('CEP') ?></th>
                    <td><?= h($supervisor->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço') ?></th>
                    <td><?= h($supervisor->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($supervisor->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Município') ?></th>
                    <td><?= h($supervisor->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($supervisor->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= h($supervisor->codigo_tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($supervisor->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= h($supervisor->codigo_cel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($supervisor->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Escola de formação em Serviço Social') ?></th>
                    <td><?= h($supervisor->escola) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano Formatura') ?></th>
                    <td><?= h($supervisor->ano_formatura) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outros Estudos') ?></th>
                    <td><?= h($supervisor->outros_estudos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Área do curso de outros estudos') ?></th>
                    <td><?= h($supervisor->area_curso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano do curso de outros estudos') ?></th>
                    <td><?= h($supervisor->ano_curso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turma do Curso de supervisores da ESS') ?></th>
                    <td><?= h($supervisor->curso_turma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Número de inscrição no Curso de supervisores da ESS') ?></th>
                    <td><?= $supervisor->num_inscricao ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observações') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($supervisor->observacoes)); ?>
                </blockquote>
            </div>
        </div>

        <div id="instituicao" class="tab-pane container fade">
            <h4><?= __('Instituição de estágio') ?></h4>
            <?php if (!empty($supervisor->instituicoes)): ?>
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Instituicao') ?></th>
                        <th><?= __('Cnpj') ?></th>
                        <th><?= __('Email') ?></th>
                        <th><?= __('Endereco') ?></th>
                        <th><?= __('Bairro') ?></th>
                        <th><?= __('Municipio') ?></th>
                        <th><?= __('Cep') ?></th>
                        <th><?= __('Telefone') ?></th>
                        <th><?= __('Convenio') ?></th>
                        <th><?= __('Expira') ?></th>
                        <th><?= __('Seguro') ?></th>
                        <th><?= __('Observacoes') ?></th>
                        <th class="row"><?= __('Ações') ?></th>
                    </tr>
                    <?php foreach ($supervisor->instituicoes as $instituicaoestagios): ?>
                        <tr>
                            <td><?= h($instituicaoestagios->id) ?></td>
                            <td><?= h($instituicaoestagios->instituicao) ?></td>
                            <td><?= h($instituicaoestagios->cnpj) ?></td>
                            <td><?= h($instituicaoestagios->email) ?></td>
                            <td><?= h($instituicaoestagios->endereco) ?></td>
                            <td><?= h($instituicaoestagios->bairro) ?></td>
                            <td><?= h($instituicaoestagios->municipio) ?></td>
                            <td><?= h($instituicaoestagios->cep) ?></td>
                            <td><?= h($instituicaoestagios->telefone) ?></td>
                            <td><?= h($instituicaoestagios->convenio) ?></td>
                            <td><?= h($instituicaoestagios->expira) ?></td>
                            <td><?= h($instituicaoestagios->seguro) ?></td>
                            <td><?= h($instituicaoestagios->observacoes) ?></td>
                            <td class="row">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Instituicoes', 'action' => 'view', $instituicaoestagios->id]) ?>
                                <?php if (isset($user) && $user->categoria == 1): ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Instituicoes', 'action' => 'edit', $instituicaoestagios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Instituicoes', 'action' => 'delete', $instituicaoestagios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $instituicaoestagios->id)]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div id="estagiarios" class="tab-pane container fade">
            <h4><?= __('Estagiarios') ?></h4>
            <?php if (!empty($supervisor->estagiarios)): ?>
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Estudante') ?></th>
                        <th><?= __('Registro') ?></th>
                        <th><?= __('Turno') ?></th>
                        <th><?= __('Nivel') ?></th>
                        <th><?= __('Docente') ?></th>
                        <th><?= __('Periodo') ?></th>
                        <th><?= __('Nota') ?></th>
                        <th><?= __('Ch') ?></th>
                        <th><?= __('Observacoes') ?></th>
                        <th class="row"><?= __('Ações') ?></th>
                    </tr>
                    <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= $this->Html->link($estagiarios->aluno['nome'], ['controller' => 'aluno', 'action' => 'view', $estagiarios->aluno_id]) ?>
                            </td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                                <td><?= $estagiarios->has('professor') ? $this->Html->link(h($estagiarios->professor['nome']), ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiarios->has('professor') ? $estagiarios->professor['nome'] : '' ?>
                                <?php endif; ?>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td class="row">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>