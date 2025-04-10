<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunos"
        aria-controls="navbarTogglerAlunos" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAlunos">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo aluno'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#aluno1" role="tab"
                aria-controls="Alunos dados pessoais" aria-selected="true">Alunos dados pessoais</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aluno2" role="tab" aria-controls="Alunos comunicação"
                aria-selected="false">Alunos comunicação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aluno3" role="tab" aria-controls="Alunos endereço"
                aria-selected="false">Alunos endereço</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="tab-content">
        <div id="aluno1" class="tab-pane container active show">
            <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                <h3><?= __('Alunos') ?></h3>
                <table class="table table-striped table-hover table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('registro') ?></th>
                            <th><?= $this->Paginator->sort('nome') ?></th>
                            <th><?= $this->Paginator->sort('nascimento') ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                            <th><?= $this->Paginator->sort('identidade') ?></th>
                            <th><?= $this->Paginator->sort('orgao', 'Orgão') ?></th>
                            <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                                <th class="row"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= $aluno->id ?></td>
                                <td><?= $aluno->registro ?></td>
                                <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                                </td>
                                <?php if (empty($aluno->nascimento)): ?>
                                    <td>Sem dados</td>
                                <?php else: ?>
                                    <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
                                <?php endif; ?>
                                <td><?= h($aluno->cpf) ?></td>
                                <td><?= h($aluno->identidade) ?></td>
                                <td><?= h($aluno->orgao) ?></td>
                                <td><?= h($aluno->observacoes) ?></td>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                                    <?php if (isset($user) && $user->categoria == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="tab-content">
            <div id="aluno2" class="tab-pane container fade">
                <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                    <h3><?= __('Alunos') ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('registro') ?></th>
                                <th><?= $this->Paginator->sort('nome') ?></th>
                                <th><?= $this->Paginator->sort('email') ?></th>
                                <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                                <th><?= $this->Paginator->sort('telefone') ?></th>
                                <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                                <th><?= $this->Paginator->sort('celular') ?></th>
                                <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                                <th class="row"><?= __('Ações') ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= $aluno->id ?></td>
                                    <td><?= $aluno->registro ?></td>
                                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                                    </td>
                                    <td><?= h($aluno->email) ?></td>
                                    <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                                    <td><?= h($aluno->telefone) ?></td>
                                    <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                                    <td><?= h($aluno->celular) ?></td>
                                    <td><?= h($aluno->observacoes) ?></td>
                                    <td class="row">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                                        <?php if (isset($user) && $user->categoria == '1'): ?>
                                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id)]) ?>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="tab-content">
            <div id="aluno3" class="tab-pane container fade">
                <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                    <h3><?= __('Alunos') ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('registro') ?></th>
                                <th><?= $this->Paginator->sort('nome') ?></th>
                                <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                                <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                                <th><?= $this->Paginator->sort('municipio') ?></th>
                                <th><?= $this->Paginator->sort('bairro') ?></th>
                                <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                                <th class="row"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= $aluno->id ?></td>
                                    <td><?= $aluno->registro ?></td>
                                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                                    </td>
                                    <td><?= h($aluno->cep) ?></td>
                                    <td><?= h($aluno->endereco) ?></td>
                                    <td><?= h($aluno->municipio) ?></td>
                                    <td><?= h($aluno->bairro) ?></td>
                                    <td><?= h($aluno->observacoes) ?></td>
                                    <td class="row">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                                        <?php if (isset($user) && $user->categoria == '1'): ?>
                                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id)]) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php $this->element('templates') ?>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>