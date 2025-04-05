<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicoes"
            aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerInstituicoes">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <caption>Instituições</caption>
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('instituicao') ?></th>
                <th><?= $this->Paginator->sort('areainstituicoes_id', 'Área institucional') ?></th>
                <th><?= $this->Paginator->sort('natureza', 'Natureza') ?></th>
                <th><?= $this->Paginator->sort('cnpj') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('url', 'URL') ?></th>
                <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                <th><?= $this->Paginator->sort('bairro') ?></th>
                <th><?= $this->Paginator->sort('municipio') ?></th>
                <th><?= $this->Paginator->sort('cep') ?></th>
                <th><?= $this->Paginator->sort('telefone') ?></th>
                <th><?= $this->Paginator->sort('fax') ?></th>
                <th><?= $this->Paginator->sort('beneficio', 'Benefício') ?></th>
                <th><?= $this->Paginator->sort('fim_de_semana') ?></th>
                <th><?= $this->Paginator->sort('localInscricao', 'Local de inscrição') ?></th>
                <th><?= $this->Paginator->sort('convenio', 'Convênio') ?></th>
                <th><?= $this->Paginator->sort('expira') ?></th>
                <th><?= $this->Paginator->sort('seguro') ?></th>
                <th><?= $this->Paginator->sort('avaliacao', 'Avaliação') ?></th>
                <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                <th class="row"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instituicaoestagios as $instituicaoestagio): ?>
                <tr>
                    <td><?= $instituicaoestagio->id ?></td>
                    <td><?= $this->Html->link($instituicaoestagio->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicaoestagio->id]) ?>
                    </td>
                    <td><?= $instituicaoestagio->has('areainstituicao') ? $this->Html->link($instituicaoestagio->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicaoestagio->areainstituicao->id]) : '' ?>
                    </td>
                    <td><?= h($instituicaoestagio->natureza) ?></td>
                    <td><?= h($instituicaoestagio->cnpj) ?></td>
                    <td><?= h($instituicaoestagio->email) ?></td>
                    <td><?= h($instituicaoestagio->url) ?></td>
                    <td><?= h($instituicaoestagio->endereco) ?></td>
                    <td><?= h($instituicaoestagio->bairro) ?></td>
                    <td><?= h($instituicaoestagio->municipio) ?></td>
                    <td><?= h($instituicaoestagio->cep) ?></td>
                    <td><?= h($instituicaoestagio->telefone) ?></td>
                    <td><?= h($instituicaoestagio->fax) ?></td>
                    <td><?= h($instituicaoestagio->beneficio) ?></td>
                    <td><?= h($instituicaoestagio->fim_de_semana) ?></td>
                    <td><?= h($instituicaoestagio->localInscricao) ?></td>
                    <td><?= $instituicaoestagio->convenio ?></td>
                    <td><?= $instituicaoestagio->expira ? date('d-m-Y', strtotime(h($instituicaoestagio->expira))) : '' ?>
                    </td>
                    <td><?= h($instituicaoestagio->seguro) ?></td>
                    <td><?= h($instituicaoestagio->avaliacao) ?></td>
                    <td><?= h($instituicaoestagio->observacoes) ?></td>
                    <td class="row">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $instituicaoestagio->id]) ?>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $instituicaoestagio->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicaoestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagio->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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