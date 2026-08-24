<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
$user = $this->getRequest()->getAttribute('identity');

// Load DataTables Bootstrap 5 CSS and JS in layout blocks
$this->Html->css('https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css', ['block' => true]);
$this->Html->script([
    'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js',
    'https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'
], ['block' => true]);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
        aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerProfessor">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item me-1">
                <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Professores', 'action' => 'buscaprofessor'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Busca professor(a)',
                    'class' => 'form-control'
                ])
                    ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor1" role="tab" aria-controls="professor1"
                    aria-selected="true">Dados funcionais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor2" role="tab" aria-controls="professor2"
                    aria-selected="false">Dados pessoais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor3" role="tab" aria-controls="professor3"
                    aria-selected="false">Dados endereço</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor4" role="tab" aria-controls="professor4"
                    aria-selected="false">Comunicação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor5" role="tab" aria-controls="professor5"
                    aria-selected="false">Curriculo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor6" role="tab" aria-controls="professor6"
                    aria-selected="false">Graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor7" role="tab" aria-controls="professor7"
                    aria-selected="false">Pós-graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor8" role="tab" aria-controls="professor8"
                    aria-selected="false">Outras informações</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="professor1" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('SIAPE') ?></th>
                        <th><?= __('Departamento') ?></th>
                        <th><?= __('Data de ingresso') ?></th>
                        <th><?= __('Forma de ingresso') ?></th>
                        <th><?= __('Tipo de cargo') ?></th>
                        <th><?= __('Categoria') ?></th>
                        <th><?= __('Regime de trabalho') ?></th>
                        <th><?= __('Data de egresso') ?></th>
                        <th><?= __('Motivo de egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->siape ?></td>
                            <td><?= $professor->departamento ?></td>
                            <td><?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->formaingresso) ?></td>
                            <td><?= h($professor->tipocargo) ?></td>
                            <td><?= h($professor->categoria) ?></td>
                            <td><?= h($professor->regimetrabalho) ?></td>
                            <td><?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor2" class="tab-pane container fade">
            <h3><?= __('Dados pessoais') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('CPF') ?></th>
                        <th><?= __('RG') ?></th>
                        <th><?= __('Órgão expedidor') ?></th>
                        <th><?= __('Sexo') ?></th>
                        <th><?= __('Data de nascimento') ?></th>
                        <th><?= __('Local de nascimento') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= h($professor->rg) ?></td>
                            <td><?= h($professor->orgaoexpedidor) ?></td>
                            <td><?php
                            if ($professor->sexo == '0') {
                                echo 'Feminino';
                            } elseif ($professor->sexo == '1') {
                                echo 'Masculino';
                            } elseif ($professor->sexo == '2') {
                                echo 'Não informado';
                            }
                            ?></td>
                            <td><?= $professor->datanascimento ? $professor->datanascimento->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->localnascimento) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor3" class="tab-pane container fade">
            <h3><?= __('Dados endereço') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Endereço') ?></th>
                        <th><?= __('Bairro') ?></th>
                        <th><?= __('Cidade') ?></th>
                        <th><?= __('Estado') ?></th>
                        <th><?= __('CEP') ?></th>
                        <th><?= __('País') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->endereco) ?></td>
                            <td><?= h($professor->bairro) ?></td>
                            <td><?= h($professor->cidade) ?></td>
                            <td><?= h($professor->estado) ?></td>
                            <td><?= h($professor->cep) ?></td>
                            <td><?= h($professor->pais) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor4" class="tab-pane container fade">
            <h3><?= __('Comunicação') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Telefone') ?></th>
                        <th><?= __('Telefone') ?></th>
                        <th><?= __('Celular') ?></th>
                        <th><?= __('Celular') ?></th>
                        <th><?= __('E-mail') ?></th>
                        <th><?= __('Homepage') ?></th>
                        <th><?= __('Rede social') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->ddd_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->ddd_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
                            </td>
                            <td><?= $professor->has('homepage') ? $this->Html->link($professor->homepage, $professor->homepage) : '' ?>
                            </td>
                            <td><?= $professor->has('redesocial') ? $this->Html->link($professor->redesocial, $professor->redesocial) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor5" class="tab-pane container fade">
            <h3><?= __('Currículo') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Lattes') ?></th>
                        <th><?= __('Última atualização') ?></th>
                        <th><?= __('Sigma') ?></th>
                        <th><?= __('DGP') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->curriculolattes ? $this->Html->link($professor->curriculolattes, $professor->curriculolattes) : '' ?>
                            </td>
                            <td><?= $professor->atualizacaolattes ? $professor->atualizacaolattes->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= $professor->curriculosigma ? $this->Html->link($professor->curriculosigma, $professor->curriculosigma) : '' ?>
                            </td>
                            <td><?= $professor->pesquisadordgp ? $this->Html->link($professor->pesquisadordgp, $professor->pesquisadordgp) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor6" class="tab-pane container fade">
            <h3><?= __('Graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Formação') ?></th>
                        <th><?= __('Área de graduação') ?></th>
                        <th><?= __('Universidade de graduação') ?></th>
                        <th><?= __('Ano de formação') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->formacaoprofissional) ?></td>
                            <td><?= h($professor->graduacaoarea) ?></td>
                            <td><?= h($professor->universidadedegraduacao) ?></td>
                            <td><?= h($professor->anoformacao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor7" class="tab-pane container fade">
            <h3><?= __('Pós-graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Área de mestrado') ?></th>
                        <th><?= __('Universidade do mestrado') ?></th>
                        <th><?= __('Ano de conclusão do mestrado') ?></th>
                        <th><?= __('Área de doutorado') ?></th>
                        <th><?= __('Universidade de doutorado') ?></th>
                        <th><?= __('Ano de conclusão do doutorado') ?></th>
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
                            <td><?= h($professor->mestradoanoconclusao) ?></td>
                            <td><?= h($professor->doutoradoarea) ?></td>
                            <td><?= h($professor->doutoradouniversidade) ?></td>
                            <td><?= h($professor->doutoradoanoconclusao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor8" class="tab-pane container fade">
            <h3><?= __('Outras informações') ?></h3>
            <table class="table table-striped table-hover table-responsive professores-table">
                <thead class="table-dark">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Nome') ?></th>
                        <th><?= __('Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->observacoes) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->element('templates') ?>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function() {
    $('.professores-table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
        },
        "pageLength": 25,
        "ordering": true,
        "stateSave": true
    });
});
<?php $this->Html->scriptEnd(); ?>