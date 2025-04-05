<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php $this->element('templates') ?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicoes"
            aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerInstituicoes">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $instituicaoestagio->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicaoestagio->id), 'class' => 'btn btn-danger float-right']
                )
                ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar instituiçoes'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($instituicaoestagio) ?>
    <fieldset>
        <legend><?= __('Editar instituição') ?></legend>
        <?php
        echo $this->Form->control('instituicao');
        echo $this->Form->control('areainstituicoes_id', ['options' => $areainstituicoes, 'empty' => true]);
        echo $this->Form->control('natureza');
        echo $this->Form->control('cnpj');
        echo $this->Form->control('email');
        echo $this->Form->control('url');
        echo $this->Form->control('endereco');
        echo $this->Form->control('bairro');
        echo $this->Form->control('municipio');
        echo $this->Form->control('cep');
        echo $this->Form->control('telefone');
        echo $this->Form->control('fax');
        echo $this->Form->control('beneficio');
        echo $this->Form->control('fim_de_semana');
        echo $this->Form->control('localInscricao');
        echo $this->Form->control('convenio');
        echo $this->Form->control('expira', ['empty' => true]);
        echo $this->Form->control('seguro');
        echo $this->Form->control('avaliacao');
        echo $this->Form->control('observacoes');
        echo $this->Form->control('supervisores._ids', ['options' => $supervisores]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>