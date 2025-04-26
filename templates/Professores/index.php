<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
        aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerProfessor">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor1" role="tab" aria-controls="professor1"
                    aria-selected="true">Professor(a) - Dados Gerais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor2" role="tab" aria-controls="professor2"
                    aria-selected="false">Professor - Comunicação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor3" role="tab" aria-controls="professor3"
                    aria-selected="false">Professor - Curriculo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor4" role="tab" aria-controls="professor4"
                    aria-selected="false">Professor - Graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor5" role="tab" aria-controls="professor5"
                    aria-selected="false">Professor - Pósgraduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor6" role="tab" aria-controls="professor6"
                    aria-selected="false">Professor - Dados funcionais</a>
            </li>

        </ul>
    </div>

    <div class="tab-content">
        <div id="professor1" class="tab-pane container active show">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>

                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                        <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                        <th><?= $this->Paginator->sort('datanascimento', 'Nascimento') ?></th>
                        <th><?= $this->Paginator->sort('localnascimento', 'Local') ?></th>
                        <th><?= $this->Paginator->sort('sexo') ?></th>

                        <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= $professor->siape ?></td>
                            <td><?= $professor->datanascimento ? date('d-m-Y', strtotime(h($professor->datanascimento))) : '' ?>
                            </td>
                            <td><?= h($professor->localnascimento) ?></td>
                            <td><?= h($professor->sexo) ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor2" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">

                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('ddd_telefone', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('ddd_celular', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                    <th><?= $this->Paginator->sort('homepage') ?></th>
                    <th><?= $this->Paginator->sort('redesocial') ?></th>

                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>

                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= $professor->siape ?></td>
                            <td><?= h($professor->ddd_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->ddd_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= h($professor->email) ?></td>
                            <td><?= h($professor->homepage) ?></td>
                            <td><?= h($professor->redesocial) ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor3" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>

                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                        <th><?= $this->Paginator->sort('atualizacaolattes') ?></th>
                        <th><?= $this->Paginator->sort('curriculosigma') ?></th>
                        <th><?= $this->Paginator->sort('pesquisadordgp') ?></th>

                        <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->curriculolattes) ?></td>
                            <td><?= h($professor->atualizacaolattes) ?></td>
                            <td><?= h($professor->curriculosigma) ?></td>
                            <td><?= h($professor->pesquisadordgp) ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor4" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>

                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?></th>
                        <th><?= $this->Paginator->sort('universidadedegraduacao') ?></th>
                        <th><?= $this->Paginator->sort('anoformacao', 'Ano') ?></th>

                        <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->formacaoprofissional ?></td>
                            <td><?= $professor->universidadedegraduacao ?></td>
                            <td><?= $professor->anoformacao ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor5" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>

                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('mestradoarea', 'Área') ?></th>
                        <th><?= $this->Paginator->sort('mestradouniversidade') ?></th>
                        <th><?= $this->Paginator->sort('mestradoanoconclusao') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoarea') ?></th>
                        <th><?= $this->Paginator->sort('doutoradouniversidade') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoanoconclusao') ?></th>

                        <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>

                            <td><?= h($professor->mestradoarea) ?></td>
                            <td><?= h($professor->mestradouniversidade) ?></td>
                            <td><?= $professor->mestradoanoconclusao ?></td>
                            <td><?= h($professor->doutoradoarea) ?></td>
                            <td><?= h($professor->doutoradouniversidade) ?></td>
                            <td><?= $professor->doutoradoanoconclusao ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor6" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>

                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('dataingresso') ?></th>
                        <th><?= $this->Paginator->sort('formaingresso') ?></th>
                        <th><?= $this->Paginator->sort('tipocargo') ?></th>
                        <th><?= $this->Paginator->sort('categoria') ?></th>
                        <th><?= $this->Paginator->sort('regimetrabalho') ?></th>
                        <th><?= $this->Paginator->sort('departamento') ?></th>
                        <th><?= $this->Paginator->sort('dataegresso') ?></th>
                        <th><?= $this->Paginator->sort('motivoegresso') ?></th>

                        <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>

                            <td><?= $professor->dataingresso ? date('d-m-Y', strtotime(h($professor->dataingresso))) : '' ?>
                            </td>
                            <td><?= h($professor->formaingresso) ?></td>
                            <td><?= h($professor->tipocargo) ?></td>
                            <td><?= h($professor->categoria) ?></td>
                            <td><?= h($professor->regimetrabalho) ?></td>
                            <td><?= h($professor->departamento) ?></td>
                            <td><?= $professor->dataegresso ? date('d-m-Y', strtotime(h($professor->dataegresso))) : '' ?>
                            </td>
                            <td><?= h($professor->motivoegresso) ?></td>

                            <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                <td class="row">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                                    <?php if (isset($user) && $user['categoria_id'] == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->element('templates'); ?>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
        <?= $this->element('paginator_count') ?>
    </div>
</div>