<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                <th><?= $this->Paginator->sort('ddd_telefone', 'DDD') ?></th>
                <th><?= $this->Paginator->sort('telefone') ?></th>
                <th><?= $this->Paginator->sort('ddd_celular', 'DDD') ?></th>
                <th><?= $this->Paginator->sort('celular') ?></th>
                <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                <th><?= $this->Paginator->sort('homepage') ?></th>
                <th><?= $this->Paginator->sort('redesocial') ?></th>
                <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                <th><?= $this->Paginator->sort('atualizacaolattes') ?></th>
                <th><?= $this->Paginator->sort('curriculosigma') ?></th>
                <th><?= $this->Paginator->sort('pesquisadordgp') ?></th>
                <th><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?></th>
                <th><?= $this->Paginator->sort('universidadedegraduacao') ?></th>
                <th><?= $this->Paginator->sort('anoformacao', 'Ano') ?></th>
                <th><?= $this->Paginator->sort('mestradoarea', 'Área') ?></th>
                <th><?= $this->Paginator->sort('mestradouniversidade') ?></th>
                <th><?= $this->Paginator->sort('mestradoanoconclusao') ?></th>
                <th><?= $this->Paginator->sort('doutoradoarea') ?></th>
                <th><?= $this->Paginator->sort('doutoradouniversidade') ?></th>
                <th><?= $this->Paginator->sort('doutoradoanoconclusao') ?></th>
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
                    <td><?= h($professor->cpf) ?></td>
                    <td><?= $professor->siape ?></td>
                    <td><?= $professor->datanascimento ? date('d-m-Y', strtotime(h($professor->datanascimento))) : '' ?>
                    </td>
                    <td><?= h($professor->localnascimento) ?></td>
                    <td><?= h($professor->sexo) ?></td>
                    <td><?= h($professor->ddd_telefone) ?></td>
                    <td><?= h($professor->telefone) ?></td>
                    <td><?= h($professor->ddd_celular) ?></td>
                    <td><?= h($professor->celular) ?></td>
                    <td><?= h($professor->email) ?></td>
                    <td><?= h($professor->homepage) ?></td>
                    <td><?= h($professor->redesocial) ?></td>
                    <td><?= h($professor->curriculolattes) ?></td>
                    <td><?= h($professor->atualizacaolattes) ?></td>
                    <td><?= h($professor->curriculosigma) ?></td>
                    <td><?= h($professor->pesquisadordgp) ?></td>
                    <td><?= h($professor->formacaoprofissional) ?></td>
                    <td><?= h($professor->universidadedegraduacao) ?></td>
                    <td><?= $professor->anoformacao ?></td>
                    <td><?= h($professor->mestradoarea) ?></td>
                    <td><?= h($professor->mestradouniversidade) ?></td>
                    <td><?= $professor->mestradoanoconclusao ?></td>
                    <td><?= h($professor->doutoradoarea) ?></td>
                    <td><?= h($professor->doutoradouniversidade) ?></td>
                    <td><?= $professor->doutoradoanoconclusao ?></td>
                    <td><?= $professor->dataingresso ? date('d-m-Y', strtotime(h($professor->dataingresso))) : '' ?>
                    </td>
                    <td><?= h($professor->formaingresso) ?></td>
                    <td><?= h($professor->tipocargo) ?></td>
                    <td><?= h($professor->categoria) ?></td>
                    <td><?= h($professor->regimetrabalho) ?></td>
                    <td><?= h($professor->departamento) ?></td>
                    <td><?= $professor->dataegresso ? date('d-m-Y', strtotime(h($professor->dataegresso))) : '' ?></td>
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

<?= $this->element('templates'); ?>
<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->element('paginator') ?>
        </ul>
    </div>
    <?= $this->element('paginator_count') ?>
</div>