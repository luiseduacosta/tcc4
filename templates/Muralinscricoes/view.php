<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($usuario->get('categoria'));
?>
<div class="container">
    <div class="row justify-content-center">
        <?php echo $this->element('menu_mural') ?>
    </div>
    <div class="row">
        <?php if ($user->categoria == 1): ?>
            <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger']) ?>
        <?php elseif ($user->categoria == 2): ?>
            <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </div>
    <div class="column-responsive column-80">
        <div class="muralinscricoes view content">
            <h3><?= h($muralinscricao->estudante->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $muralinscricao->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $muralinscricao->id_aluno ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudante') ?></th>
                    <td><?= $muralinscricao->has('estudante') ? $this->Html->link($muralinscricao->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $muralinscricao->estudante->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Inscrição para estagio') ?></th>
                    <td><?= $muralinscricao->has('muralestagio') ? $this->Html->link($muralinscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio->id]) : '' ?></td>
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
    </div>
</div>