<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>
<div class="container">
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <?= $this->Html->link(__('Edit Userestagio'), ['action' => 'edit', $userestagio->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Delete Userestagio'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagio->id), 'class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('List Userestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('New Userestagio'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="userestagios view content">
                <h3><?= h($userestagio->id) ?></h3>
                <table>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= h($userestagio->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Password') ?></th>
                        <td><?= h($userestagio->password) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Categoria') ?></th>
                        <td><?= h($userestagio->categoria) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Estudante') ?></th>
                        <td><?= $userestagio->has('estudante') ? $this->Html->link($userestagio->estudante->id, ['controller' => 'Estudantes', 'action' => 'view', $userestagio->estudante->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Supervisor') ?></th>
                        <td><?= $userestagio->has('supervisor') ? $this->Html->link($userestagio->supervisor->id, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Docente') ?></th>
                        <td><?= $userestagio->has('docente') ? $this->Html->link($userestagio->docente->id, ['controller' => 'Docentes', 'action' => 'view', $userestagio->docente->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $userestagio->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Numero') ?></th>
                        <td><?= $userestagio->numero ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Timestamp') ?></th>
                        <td><?= h($userestagio->timestamp) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>