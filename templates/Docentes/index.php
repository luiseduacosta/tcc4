<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Docentes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($docentes);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentes"
        aria-controls="navbarTogglerDocentes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDocentes">
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerDocentes">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="item-link">
                    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#docente1" role="tab" aria-controls="docente1"
                    aria-selected="true">Dados Gerais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente2" role="tab" aria-controls="docente2"
                    aria-selected="false">Dados funcionais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente3" role="tab" aria-controls="docente3"
                    aria-selected="false">Dados pessoais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente4" role="tab" aria-controls="docente4"
                    aria-selected="false">Graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente5" role="tab" aria-controls="docente5"
                    aria-selected="false">Pósgraduação</a>
            </li>

        </ul>
    </div>

    <div class="tab-content">
        <div id="docente1" class="tab-pane container active show">
            <h3><?= __('Docentes') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->departamento) ?></td>
                            <td><?= h($docente->homepage) ?></td>
                            <td>
                                <?php if ($docente->curriculolattes): ?>
                                    <a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Lattes</a>
                                <?php endif; ?>
                            </td>
                            <td><?= h($docente->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente2" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-responsive table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('siape') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dataingresso', 'Data de ingresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('formaingresso', 'Forma de ingresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->siape) ?></td>
                            <td><?= h($docente->departamento) ?></td>
                            <td><?= h($docente->dataingresso) ?></td>
                            <td><?= h($docente->formaingresso) ?></td>
                            <td><?= h($docente->tipocargo) ?></td>
                            <td><?= h($docente->categoria) ?></td>
                            <td><?= h($docente->regimetrabalho) ?></td>
                            <td><?= h($docente->dataegresso) ?></td>
                            <td><?= h($docente->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente3" class="tab-pane container active show">
            <h3><?= __('Dados pessoais') ?></h3>
            <table class="table table-hover table-responsive table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cpf') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('sexo') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('datanascimento', 'Nascimento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('localnascimento', 'Local') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('redesocial', 'Rede social') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->cpf) ?></td>
                            <td>
                                <?php
                                if ($docente->sexo == '1'):
                                    echo "Masculino";
                                elseif ($docente->sexo == '2'):
                                    echo "Feminino";
                                else:
                                    echo "s/d";
                                endif;
                                ?>
                            </td>
                            <td><?= h($docente->datanascimento) ?></td>
                            <td><?= h($docente->localnascimento) ?></td>
                            <td><?= '(' . h($docente->ddd_telefone) . ')' . h($docente->telefone) ?></td>
                            <td><?= '(' . h($docente->ddd_celular) . ')' . h($docente->celular) ?></td>
                            <td><?= h($docente->email) ?></td>
                            <td><?= $docente->has('homepage') ? $this->html->link($docente->homepage, $docente->homepage) : '' ?>
                            </td>
                            <td><?= $docente->has('redesocial') ? $this->html->link($docente->redesocial, $docente->redesocial) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente4" class="tab-pane container active show">
            <h3><?= __('Graduação') ?></h3>
            <table class="table table-responsive table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('atualizacaolattes', 'Atualização') ?>
                        </th>
                        <th scope="col"><?= $this->Paginator->sort('pesquisadordgp') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?>
                        </th>
                        <th scope="col">
                            <?= $this->Paginator->sort('universidadedegraduacao', 'Universidade') ?>
                        </th>
                        <th scope="col"><?= $this->Paginator->sort('anoformacao', 'Ano') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td>
                                <?php if ($docente->curriculolattes): ?>
                                    <a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Lattes</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($docente->atualizacaolattes): ?>
                                    <?= h($docente->atualizacaolattes) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($docente->pesquisadordgp): ?>
                                    <a href='<?= 'http://dgp.cnpq.br/dgp/espelhogrupo/' . $docente->pesquisadordgp ?>'>Grupo
                                        de pesquisa
                                        Lattes</a>
                                <?php endif; ?>
                            </td>
                            <td><?= h($docente->formacaoprofissional) ?></td>
                            <td><?= h($docente->universidadedegraduacao) ?></td>
                            <td><?= h($docente->anoformacao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente5" class="tab-pane container active show">
            <h3><?= __('Pósgraduação') ?></h3>
            <table class="table table-responsive table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('mestradoarea', "Área") ?></th>
                        <th scope="col">
                            <?= $this->Paginator->sort('mestradouniversidade', 'Universidade') ?>
                        </th>
                        <th scope="col">
                            <?= $this->Paginator->sort('mestradoanoconclusao', 'Conclusão') ?>
                        </th>
                        <th scope="col"><?= $this->Paginator->sort('doutoradoarea', "Área") ?></th>
                        <th scope="col">
                            <?= $this->Paginator->sort('doutoradouniversidade', "Universidade") ?>
                        </th>
                        <th scope="col">
                            <?= $this->Paginator->sort('doutoradoanoconclusao', "Conclusão") ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->mestradoarea) ?></td>
                            <td><?= h($docente->mestradouniversidade) ?></td>
                            <td><?= h($docente->mestradoanoconclusao) ?></td>
                            <td><?= h($docente->doutoradoarea) ?></td>
                            <td><?= h($docente->doutoradouniversidade) ?></td>
                            <td><?= h($docente->doutoradoanoconclusao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <?= $this->element('templates') ?>
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