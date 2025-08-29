<?php

use Cake\I18n\Time;
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resposta> $respostas
 */
// pr($respostas);
// die();
?>

<?php echo $this->element('menu_mural') ?>
<?php $this->element('templates') ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <?= $this->Html->link(__('Nova resposta'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <h3><?= __('Respostas') ?></h3>
    <div class="container mt-4">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estagiario.aluno.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('estagiarios_id', 'Nível de estágio') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respostas as $resposta): ?>
                    <tr>
                        <td><?= $this->Number->format($resposta->id) ?></td>
                        <td><?=  $this->Html->link($resposta->estagiario->aluno->nome, ['controller' => 'Questiones', 'action' => 'view', $resposta->estagiario->aluno->id]) ?>
                        </td>
                        <td><?= $resposta->has('estagiario') ? $this->Html->link($resposta->estagiario->nivel, ['controller' => 'Estagiarios', 'action' => 'view', $resposta->estagiario->id]) : '' ?>
                        </td>
                        <td><?= $this->Time->format($resposta->created, 'd-MM-Y HH:mm:ss') ?></td>
                        <td><?= $this->Time->format($resposta->modified, 'd-MM-Y HH:mm:ss') ?></td>
                        <td class="d-grid">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $resposta->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>

</div>