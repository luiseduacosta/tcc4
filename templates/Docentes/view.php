<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($docente);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
?>

<div class="d-flex justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDocentesView"
        aria-controls="navbarTogglerDocentesView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerDocentesView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Html->link(__('Editar Docente'), ['action' => 'edit', $docente->id], ['class' => 'btn btn-primary float-start']) ?>
            </li>
            <li class="item-link">
                <?= $this->Form->postLink(__('Excluir Docente'), ['action' => 'delete', $docente->id], ['confirm' => __('Tem certeza que quer exclir este registro # {0}?', $docente->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($docente->nome) ?></h3>
    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Nome') ?></th>
                    <th scope="col"><?= __('Departamento') ?></th>
                    <th scope="col"><?= __('Homepage') ?></th>
                    <th scope="col"><?= __('Curriculo Lattes') ?></th>
                    <th scope="col"><?= __('Motivo Egresso') ?></th>
                </tr>
            </thead>
            <tr>
                <td colspan="2">Dados pessoais</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Nome') ?></th>
                <td><?= h($docente->nome) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('CṔF') ?></th>
                <td><?= h($docente->cpf) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sexo') ?></th>
                <td>
                    <?php if ($docente->sexo == '1'): ?>
                        <?= 'Masculino'; ?>
                    <?php elseif ($docente->sexo == '2'): ?>
                        <?= 'Feminino'; ?>
                    <?php else: ?>
                        <?= "s/d" ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de nascimento') ?></th>
                <td><?= h($docente->datanascimento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Local de nascimento') ?></th>
                <td><?= h($docente->localnascimento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Telefone') ?></th>
                <td><?= h('(' . h($docente->ddd_telefone) . ')' . h($docente->telefone)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Celular') ?></th>
                <td><?= h('(' . h($docente->ddd_celular) . ')' . h($docente->celular)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('E-mail') ?></th>
                <td><?= h($docente->email) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Site') ?></th>
                <td><?= $docente->has('homepage') ? $this->Html->link($docente->homepage, $docente->homepage) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rede social') ?></th>
                <td><?= $docente->has('redesocial') ? $this->Html->link($docente->redesocial, $docente->redesocial) : '' ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">Dados acadêmicos</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Curriculo lattes') ?></th>
                <td><a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Currículo</a></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Atualização lattes') ?></th>
                <td><?= h($docente->atualizacaolattes) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Curriculo Sigma') ?></th>
                <td><?= h($docente->curriculosigma) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Diretório de Grupos de Pesquisa') ?></th>
                <td><a href='http://dgp.cnpq.br/dgp/espelhogrupo/<?= $docente->pesquisadordgp ?>'>Grupo de pesquisa</a></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Formação profissional') ?></th>
                <td><?= h($docente->formacaoprofissional) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Universidade de graduação') ?></th>
                <td><?= h($docente->universidadedegraduacao) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Ano formação') ?></th>
                <td><?= h($docente->anoformacao) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado área') ?></th>
                <td><?= h($docente->mestradoarea) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado universidade') ?></th>
                <td><?= h($docente->mestradouniversidade) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado ano conclusão') ?></th>
                <td><?= $this->Number->format($docente->mestradoanoconclusao) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Doutorado área') ?></th>
                <td><?= h($docente->doutoradoarea) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Doutorado universidade') ?></th>
                <td><?= h($docente->doutoradouniversidade) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Doutorado ano conclusão') ?></th>
                <td><?= h($docente->doutoradoanoconclusao) ?></td>
            </tr>

            <tr>
                <td colspan="2">Dados funcionais</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Siape') ?></th>
                <td><?= $this->Number->format($docente->siape) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Departamento') ?></th>
                <td><?= h($docente->departamento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Forma de ingresso') ?></th>
                <td><?= h($docente->formaingresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de ingresso') ?></th>
                <td><?= h($docente->dataingresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Tipo de cargo') ?></th>
                <td><?= h($docente->tipocargo) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Classe e nível') ?></th>
                <td><?= h($docente->categoria) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Regime de trabalho') ?></th>
                <td><?= h($docente->regimetrabalho) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de egresso') ?></th>
                <td><?= h($docente->dataegresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Motivo de egresso') ?></th>
                <td><?= h($docente->motivoegresso) ?></td>
            </tr>

        </table>
        <div class="row">
            <p><?= __('Observacoes') ?></p>
            <?= $this->Text->autoParagraph(h($docente->observacoes)); ?>
        </div>
    <?php endif; ?>

    <div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <h4><?= __('Monografias') ?></h4>
        <?php if (!empty($docente->monografias)): ?>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= __('Titulo') ?></th>
                        <th scope="col"><?= __('Periodo') ?></th>
                        <th scope="col"><?= __('Pdf') ?></th>
                    </tr>
                </thead>
                <?php foreach ($docente->monografias as $monografias): ?>
                    <tr>
                        <td><?= $this->Html->link($monografias->titulo, ['controller' => 'monografias', 'action' => 'view', $monografias->id]) ?>
                        </td>
                        <td><?= h($monografias->periodo) ?></td>
                        <td><?= $this->Html->link($monografias->url, ['controller' => 'monografias', 'action' => 'download', $monografias->url, $monografias->id]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <h4><?= __('Áreas') ?></h4>
        <?php if (!empty($docente->areamonografias)): ?>
            <?php // pr($docente->areas); ?>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= __('Área') ?></th>
                    </tr>
                </thead>
                <?php foreach ($docente->areamonografias as $docentesAreas): ?>
                    <?php // pr($docentesAreas); ?>
                    <tr>
                        <td><?= $this->Html->link($docentesAreas->area, ['controller' => 'areamonografias', 'action' => 'view', $docentesAreas->id]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>