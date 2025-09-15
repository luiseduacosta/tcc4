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

<div class="container mt-1">

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
                        <td><?= $this->Html->link($resposta->estagiario->aluno->nome, ['controller' => 'Respostas', 'action' => 'view', $resposta->id]) ?>
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

    <div class="row mt-4">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ' . __('primeiro'), ['templates' => ['first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']]) ?>
            <?= $this->Paginator->prev('< ' . __('anterior'), ['templates' =>['prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>'], ['prevDisabled' => '<li class="page-item disabledá"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']]) ?>
            <?= $this->Paginator->numbers(['templates' => ['number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>'], ['current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>']]) ?>
            <?= $this->Paginator->next(__('próximo') . ' >', ['templates' => ['nextActive' => '<li class="page-item"><a class="page-link" rel="próximo" href="{{url}}">{{text}}</a></li>'], ['nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']]) ?>
            <?= $this->Paginator->last(__('último') . ' >>', ['templates' => ['last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']]) ?>
        </ul>
        <p class="text-center">
            <?= $this->Paginator->counter( __('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.'), ['tempates' => [['counterRange' => '{{start}} - {{end}} de {{count}}'], ['counterPages' => '{{page}} de {{pages}}']]]) ?>
        </p>
    </div>

</div>