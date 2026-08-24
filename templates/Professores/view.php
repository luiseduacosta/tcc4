<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
use Cake\I18n\FrozenDate;

// $user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
            aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerProfessor">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Professor(a)'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir Professor(a)'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $professor->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Professore(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) Professor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '3'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Professor'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#professor" role="tab" aria-controls="professor"
                aria-selected="true">Professor(a)</a>
        </li>
    </ul>
</div>

<div class="tab-content">

    <div id="professor" class="tab-pane container active show">

        <h3><?= h($professor->nome) ?></h3>

        <h4><?= __('Dados pessoais do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Id') ?></dt>
            <dd class="col-sm-9"><?= $professor->id ?></dd>

            <dt class="col-sm-3"><?= __('Nome') ?></dt>
            <dd class="col-sm-9"><?= h($professor->nome) ?></dd>

            <dt class="col-sm-3"><?= __('CPF') ?></dt>
            <dd class="col-sm-9"><?= h($professor->cpf) ?></dd>
        </dl>

        <h4><?= __('Dados funcionais do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('SIAPE') ?></dt>
            <dd class="col-sm-9"><?= $professor->siape ?></dd>

            <dt class="col-sm-3"><?= __('CRESS') ?></dt>
            <dd class="col-sm-9"><?= h($professor->cress) ?></dd>

            <dt class="col-sm-3"><?= __('Região') ?></dt>
            <dd class="col-sm-9"><?= h($professor->regiao) ?></dd>

            <dt class="col-sm-3"><?= __('Data de ingresso') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Departamento') ?></dt>
            <dd class="col-sm-9"><?= h($professor->departamento) ?></dd>

            <dt class="col-sm-3"><?= __('Data de egresso') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Motivo egresso') ?></dt>
            <dd class="col-sm-9"><?= h($professor->motivoegresso) ?></dd>

            <dt class="col-sm-3"><?= __('Status') ?></dt>
            <dd class="col-sm-9"><?= h($professor->status) ?></dd>
        </dl>

        <h4><?= __('Dados de contato do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Código Telefone') ?></dt>
            <dd class="col-sm-9"><?= h($professor->codigo_telefone) ?></dd>

            <dt class="col-sm-3"><?= __('Telefone') ?></dt>
            <dd class="col-sm-9"><?= h($professor->telefone) ?></dd>

            <dt class="col-sm-3"><?= __('Código Celular') ?></dt>
            <dd class="col-sm-9"><?= h($professor->codigo_celular) ?></dd>

            <dt class="col-sm-3"><?= __('Celular') ?></dt>
            <dd class="col-sm-9"><?= h($professor->celular) ?></dd>

            <dt class="col-sm-3"><?= __('E-mail') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
            </dd>
        </dl>

        <h4><?= __('Dados acadêmicos do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Currículo Lattes') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->curriculolattes ? $this->Html->link($professor->curriculolattes, 'https://lattes.cnpq.br/' . $professor->curriculolattes, ['target' => '_blank', 'full' => true]) : '' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Atualização Lattes') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->atualizacaolattes ? $professor->atualizacaolattes->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>
        </dl>

        <h4><?= __('Outras informações do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Observações') ?></dt>
            <dd class="col-sm-9"><?= $this->Text->autoParagraph(h($professor->observacoes)); ?>
            </dd>
        </dl>

    </div>

</div>