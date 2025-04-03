<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($usuario->get('categoria'));
?>

<div class="d-flex justify-content-center">
    <?php echo $this->element('menu_mural') ?>
</div>

<div class="d-flex justify-content-start">
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger']) ?>
    <?php elseif (isset($user) && $user->categoria == '2'): ?>
        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger']) ?>
    <?php endif; ?>
</div>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($muralinscricao->aluno['nome']) ?></h3>
    <table>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $muralinscricao->id ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <td><?= $muralinscricao->registro ?></td>
        </tr>
        <tr>
            <th><?= __('Estudante') ?></th>
            <td><?= $muralinscricao->has('aluno') ? $this->Html->link($muralinscricao->aluno['nome'], ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Inscrição para estagio') ?></th>
            <td><?= $muralinscricao->has('muralestagio') ? $this->Html->link($muralinscricao->muralestagio['instituicao'], ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Período') ?></th>
            <td><?= h($muralinscricao->periodo) ?></td>
        </tr>
        <tr>
            <th><?= __('Data') ?></th>
            <td><?= date('d-m-Y', strtotime(h($muralinscricao->data))) ?></td>
        </tr>
        <tr>
            <th><?= __('Timestamp') ?></th>
            <td><?= date('d-m-Y', strtotime(h($muralinscricao->timestamp))) ?></td>
        </tr>
    </table>
</div>