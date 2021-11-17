<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($usuario->get('categoria'));
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?php if ($usuario->categoria == 1): ?>
                    <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                <?php elseif ($usuario->get('categoria') == 2): ?>
                    <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricao->id), 'class' => 'side-nav-item']) ?>
                <?php endif; ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="muralinscricoes view content">
                <h3><?= h($muralinscricao->id) ?></h3>
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
</div>