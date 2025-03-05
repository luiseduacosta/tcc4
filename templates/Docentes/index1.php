<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>

<div class="justify-content-start">
    <?= $this->element('menu_esquerdo') ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDocentes"
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

<div class="row">
    <h3><?= __('Docentes') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentes', 'action' => 'index0'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentes', 'action' => 'index1'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentes', 'action' => 'index2'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentes', 'action' => 'index3'], ['class' => 'btn btn-primary float-end']) ?>
        <?php endif; ?>
    </p>
</div>

<div class="row">
    <table class="table">
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
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?>
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

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
</div>