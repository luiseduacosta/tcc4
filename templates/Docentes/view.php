<?php
/**
 * @var \App\View\AppView $this 
 * @var \App\Model\Entity\Docente $docente 
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($docente);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentesView"
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
        <dl class="row">

            <dt class="table-dark">Dados pessoais</dt>
            <dd></dd>

            <dt scope="row"><?= __('Nome') ?></dt>
            <dd><?= h($docente->nome) ?></dd>

            <dt scope="row"><?= __('CṔF') ?></dt>
            <dd><?= h($docente->cpf) ?></dd>

            <dt scope="row"><?= __('Sexo') ?></dt>
            <dd>
                <?php if ($docente->sexo == '1'): ?>
                    <?= 'Masculino'; ?>
                <?php elseif ($docente->sexo == '2'): ?>
                    <?= 'Feminino'; ?>
                <?php else: ?>
                    <?= "s/d" ?>
                <?php endif; ?>
            </dd>

            <dt scope="row"><?= __('Data de nascimento') ?></dt>
            <dd><?= h($docente->datanascimento) ?></dd>

            <dt scope="row"><?= __('Local de nascimento') ?></dt>
            <dd><?= h($docente->localnascimento) ?></dd>

            <dt scope="row"><?= __('Telefone') ?></dt>
            <dd><?= h('(' . h($docente->ddd_telefone) . ')' . h($docente->telefone)) ?></dd>

            <dt scope="row"><?= __('Celular') ?></dt>
            <dd><?= h('(' . h($docente->ddd_celular) . ')' . h($docente->celular)) ?></dd>

            <dt scope="row"><?= __('E-mail') ?></dt>
            <dd><?= h($docente->email) ?></dd>

            <dt scope="row"><?= __('Site') ?></dt>
            <dd><?= $docente->has('homepage') ? $this->Html->link($docente->homepage, $docente->homepage) : '' ?></dd>

            <dt scope="row"><?= __('Rede social') ?></dt>
            <dd><?= $docente->has('redesocial') ? $this->Html->link($docente->redesocial, $docente->redesocial) : '' ?></dd>

        </dl>

        <dl>
            <dt class="table-dark">Dados acadêmicos</dt>
            <dd></dd>

            <dt scope="row"><?= __('Curriculo lattes') ?></dt>
            <dd><a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Currículo</a></dd>

            <dt scope="row"><?= __('Atualização lattes') ?></dt>
            <dd><?= h($docente->atualizacaolattes) ?></dd>

            <dt scope="row"><?= __('Curriculo Sigma') ?></dt>
            <dd><?= h($docente->curriculosigma) ?></dd>

            <dt scope="row"><?= __('Diretório de Grupos de Pesquisa') ?></dt>
            <dd><a href='http://dgp.cnpq.br/dgp/espelhogrupo/<?= $docente->pesquisadordgp ?>'>Grupo de pesquisa</a></dd>

            <dt scope="row"><?= __('Formação profissional') ?></dt>
            <dd><?= h($docente->formacaoprofissional) ?></dd>

            <dt scope="row"><?= __('Universidade de graduação') ?></dt>
            <dd><?= h($docente->universidadedegraduacao) ?></dd>

            <dt scope="row"><?= __('Ano formação') ?></dt>
            <dd><?= h($docente->anoformacao) ?></dd>

            <dt scope="row"><?= __('Mestrado área') ?></dt>
            <dd><?= h($docente->mestradoarea) ?></dd>

            <dt scope="row"><?= __('Mestrado universidade') ?></dt>
            <dd><?= h($docente->mestradouniversidade) ?></dd>

            <dt scope="row"><?= __('Mestrado ano conclusão') ?></dt>
            <dd><?= $this->Number->format($docente->mestradoanoconclusao) ?></dd>

            <dt scope="row"><?= __('Doutorado área') ?></dt>
            <dd><?= h($docente->doutoradoarea) ?></dd>

            <dt scope="row"><?= __('Doutorado universidade') ?></dt>
            <dd><?= h($docente->doutoradouniversidade) ?></dd>

            <dt scope="row"><?= __('Doutorado ano conclusão') ?></dt>
            <dd><?= h($docente->doutoradoanoconclusao) ?></dd>

        </dl>

        <dl>
            <dt class="table-dark">Dados funcionais</dt>
            <dd></dd>

            <dt scope="row"><?= __('Siape') ?></dt>
            <dd><?= $this->Number->format($docente->siape) ?></dd>

            <dt scope="row"><?= __('Departamento') ?></dt>
            <dd><?= h($docente->departamento) ?></dd>

            <dt scope="row"><?= __('Forma de ingresso') ?></dt>
            <dd><?= h($docente->formaingresso) ?></dd>

            <dt scope="row"><?= __('Data de ingresso') ?></dt>
            <dd><?= h($docente->dataingresso) ?></dd>

            <dd scope="row"><?= __('Tipo de cargo') ?></dd>
            <dt><?= h($docente->tipocargo) ?></dt>

            <dt scope="row"><?= __('Classe e nível') ?></dt>
            <dd><?= h($docente->categoria) ?></dd>

            <dt scope="row"><?= __('Regime de trabalho') ?></dt>
            <dd><?= h($docente->regimetrabalho) ?></dd>

            <dt scope="row"><?= __('Data de egresso') ?></dt>
            <dd><?= h($docente->dataegresso) ?></dd>

            <dt scope="row"><?= __('Motivo de egresso') ?></dt>
            <dd><?= h($docente->motivoegresso) ?></dd>

            <dt><?= __('Observacoes') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($docente->observacoes)); ?></dd>
        </dl>
    </div>
<?php endif; ?>

<?php // pr($docente->monografias) ?>

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
                <?php // pr($monografias); ?>
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
            <?php foreach ($docente->areamonografias as $professoresAreas): ?>
                <?php // pr($ProfessoresAreas); ?>
                <tr>
                    <td><?= $this->Html->link($professoresAreas->area, ['controller' => 'areamonografias', 'action' => 'view', $professoresAreas->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>