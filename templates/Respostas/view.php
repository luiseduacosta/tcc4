<?php

use Cake\I18n\Time;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 */
// pr($resposta);
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#resposta"
            aria-controls="resposta" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="resposta">
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <h3><?= h($resposta->id) ?></h3>
        <table class="table table-responsive table-striped table-hover">
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($resposta->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Aluno') ?></th>
                <td><?= $this->Html->link($resposta->estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $resposta->estagiario->aluno->id]) ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Nível de estágio') ?></th>
                <td><?= $resposta->has('estagiario') ? $this->Html->link($resposta->estagiario->nivel, ['controller' => 'Estagiarios', 'action' => 'view', $resposta->estagiario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <td class="text">
                    <strong><?= __('Resposta') ?></strong>
                    <blockquote>
                        <?= $this->Text->autoParagraph(h($resposta->response)); ?>
                    </blockquote>
                </td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= $this->Time->format($resposta->created, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= $this->time->format($resposta->modified, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
        </table>
    </div>
</div>