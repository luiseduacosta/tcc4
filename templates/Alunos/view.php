<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($aluno);
?>

<div class="d-flex justify-content-center">
    <?php echo $this->element('menu_mural') ?>
</div>

<div class="d-flex justify-content-end">
    <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Editar Aluno'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->postLink(__('Excluir Aluno'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id), 'class' => 'btn btn-danger float-end']) ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($aluno->nome) ?></h3>
    <table class="table table-hover table-responsive table-striped">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $aluno->id ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <td><?= $aluno->registro ?></td>
        </tr>
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($aluno->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Nascimento') ?></th>
            <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
        </tr>
        <tr>
            <th><?= __('Cpf') ?></th>
            <td><?= h($aluno->cpf) ?></td>
        </tr>
        <tr>
            <th><?= __('Identidade') ?></th>
            <td><?= h($aluno->identidade) ?></td>
        </tr>
        <tr>
            <th><?= __('Orgao') ?></th>
            <td><?= h($aluno->orgao) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($aluno->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Codigo Telefone') ?></th>
            <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
        </tr>
        <tr>
            <th><?= __('Telefone') ?></th>
            <td><?= h($aluno->telefone) ?></td>
        </tr>
        <tr>
            <th><?= __('Codigo Celular') ?></th>
            <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
        </tr>
        <tr>
            <th><?= __('Celular') ?></th>
            <td><?= h($aluno->celular) ?></td>
        </tr>
        <tr>
            <th><?= __('Cep') ?></th>
            <td><?= h($aluno->cep) ?></td>
        </tr>
        <tr>
            <th><?= __('Endereco') ?></th>
            <td><?= h($aluno->endereco) ?></td>
        </tr>
        <tr>
            <th><?= __('Municipio') ?></th>
            <td><?= h($aluno->municipio) ?></td>
        </tr>
        <tr>
            <th><?= __('Bairro') ?></th>
            <td><?= h($aluno->bairro) ?></td>
        </tr>
        <tr>
            <th><?= __('Observações') ?></th>
            <td><?= h($aluno->observacoes) ?></td>
        </tr>
    </table>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Inscrições para seleção de estágio') ?></h4>
    <?php if (!empty($aluno->muralinscricoes)): ?>
        <table class="table table-hover table-responsive table-striped">
            <thead class="table-dark">
                <tr>
                    <th><?= __('Id') ?></th>
                    <th><?= __('Registro') ?></th>
                    <th><?= __('Estudante') ?></th>
                    <th><?= __('Muralestagio') ?></th>
                    <th><?= __('Data') ?></th>
                    <th><?= __('Periodo') ?></th>
                    <th><?= __('Timestamp') ?></th>
                    <th class="row"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <?php foreach ($aluno->muralinscricoes as $muralinscricoes): ?>
                <tr>
                    <td><?= h($muralinscricoes->id) ?></td>
                    <td><?= h($muralinscricoes->aluno_id) ?></td>
                    <td><?= $muralinscricoes->has('muralestagio') ? $this->Html->link($muralinscricoes->muralestagio['instituicao'], ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricoes['instituicao_id']]) : '' ?>
                    </td>
                    <td><?= date('d-m-Y', strtotime(h($muralinscricoes->data))) ?></td>
                    <td><?= h($muralinscricoes->periodo) ?></td>
                    <td><?= date('d-m-Y', strtotime(h($muralinscricoes->timestamp))) ?></td>

                    <td class="row">
                        <?= $this->Html->link(__('View'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                        <?php endif ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Estágios cursados') ?></h4>
    <?php if (!empty($aluno->estagiarios)): ?>
        <table class="table table-hover table-responsive table-striped">
            <thead class="table-dark">
                <tr>
                    <th><?= __('Id') ?></th>
                    <th><?= __('Aluno') ?></th>
                    <th><?= __('Estagiario') ?></th>
                    <th><?= __('Ajuste 2020') ?></th>
                    <th><?= __('Turno') ?></th>
                    <th><?= __('Nivel') ?></th>
                    <th><?= __('Período') ?></th>
                    <th><?= __('Tc') ?></th>
                    <th><?= __('Tc Solicitação') ?></th>
                    <th><?= __('Instituição de estagio') ?></th>
                    <th><?= __('Supervisor') ?></th>
                    <th><?= __('Docente') ?></th>
                    <th><?= __('Àrea de estágio') ?></th>
                    <th><?= __('Nota') ?></th>
                    <th><?= __('CH') ?></th>
                    <th><?= __('Observações') ?></th>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <th class="row"><?= __('Ações') ?></th>
                    <?php endif ?>
                </tr>
            </thead>
            <?php foreach ($aluno->estagiarios as $estagiarios): ?>
                <tr>
                    <?php // pr($estagiarios); ?>
                    <td><?= h($estagiarios->id) ?></td>
                    <td><?= h($estagiarios->aluno['nome']) ?></td>
                    <td><?= h($estagiarios->registro) ?></td>
                    <td><?= h($estagiarios->ajuste2020) ?></td>
                    <td><?= h($estagiarios->turno) ?></td>
                    <td><?= h($estagiarios->nivel) ?></td>
                    <td><?= h($estagiarios->periodo) ?></td>
                    <td><?= h($estagiarios->tc) ?></td>
                    <td><?= date('d-m-Y', strtotime(h($estagiarios->tc_solicitacao))) ?></td>
                    <td><?= $estagiarios->has('instituicao') ? $this->Html->link($estagiarios->instituicao['instituicao'], ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?>
                    </td>
                    <td><?= $estagiarios->has('supervisor') ? $this->Html->link($estagiarios->supervisor['nome'], ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                    </td>
                    <td><?= $estagiarios->has('professor') ? $this->Html->link($estagiarios->professor['nome'], ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                    </td>
                    <td><?= $estagiarios->has('areaestagio') ? h($estagiarios->turmaestagio['area']) : '' ?></td>
                    <td><?= h($estagiarios->nota) ?></td>
                    <td><?= h($estagiarios->ch) ?></td>
                    <td><?= h($estagiarios->observacoes) ?></td>
                    <td class="row">
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                        <?php endif ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>