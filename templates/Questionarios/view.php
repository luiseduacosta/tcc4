<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questionario $questionario
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questionario->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questionario->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questionario->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <h3><?= h($questionario->title) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Titulo') ?></th>
                <td><?= $this->Html->link($questionario->title, ['controller' => 'Questiones', 'action' => 'index']) ?></td>
            </tr>
            <tr>
                <th><?= __('Categoria') ?></th>
                <td><?= h($questionario->category) ?></td>
            </tr>
            <tr>
                <th><?= __('Usuário alvo') ?></th>
                <td><?= h($questionario->target_user_type) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questionario->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= h($questionario->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= h($questionario->modified) ?></td>
            </tr>
            <tr>
                <th><?= __('Activo') ?></th>
                <td><?= $questionario->is_active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
        <div class="container mt-1">
            <strong><?= __('Descrição') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($questionario->description)); ?>
            </blockquote>
        </div>
        <div class="container mt-1">
            <h4><?= __('Questões') ?></h4>
            <?php if (!empty($questionario->questiones)): ?>
                <div class="container mr-1">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Questionario Id') ?></th>
                            <th><?= __('Texto') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Opções') ?></th>
                            <th><?= __('Criado') ?></th>
                            <th><?= __('Modificado') ?></th>
                            <th><?= __('Ordem') ?></th>
                            <th><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($questionario->questiones as $questiones): ?>
                            <tr>
                                <td><?= h($questiones->id) ?></td>
                                <td><?= h($questiones->questionario_id) ?></td>
                                <td><?= h($questiones->text) ?></td>
                                <td><?= h($questiones->type) ?></td>
                                <td><?= h($questiones->options) ?></td>
                                <td><?= h($questiones->created) ?></td>
                                <td><?= h($questiones->modified) ?></td>
                                <td><?= h($questiones->ordem) ?></td>
                                <td class="table-info">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Questiones', 'action' => 'view', $questiones->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Questiones', 'action' => 'edit', $questiones->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Questiones', 'action' => 'delete', $questiones->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questiones->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>