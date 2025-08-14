<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questionario $questionario
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="container">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <li class="nav-item">
                <?= $this->Html->link(__('Edit Questionario'), ['action' => 'edit', $questionario->id], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Delete Questionario'), ['action' => 'delete', $questionario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionario->id), 'class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('List Questionarios'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('New Questionario'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container-fluid mt-4">
        <h3><?= h($questionario->title) ?></h3>
        <table>
            <tr>
                <th><?= __('Title') ?></th>
                <td><?= h($questionario->title) ?></td>
            </tr>
            <tr>
                <th><?= __('Category') ?></th>
                <td><?= h($questionario->category) ?></td>
            </tr>
            <tr>
                <th><?= __('Target User Type') ?></th>
                <td><?= h($questionario->target_user_type) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questionario->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($questionario->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($questionario->modified) ?></td>
            </tr>
            <tr>
                <th><?= __('Is Active') ?></th>
                <td><?= $questionario->is_active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
        <div class="text">
            <strong><?= __('Description') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($questionario->description)); ?>
            </blockquote>
        </div>
        <div class="related">
            <h4><?= __('Related Questiones') ?></h4>
            <?php if (!empty($questionario->questiones)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Questionario Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Options') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Order') ?></th>
                            <th class="table-info"><?= __('Actions') ?></th>
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
                                <td><?= h($questiones->order) ?></td>
                                <td class="table-info">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Questiones', 'action' => 'view', $questiones->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Questiones', 'action' => 'edit', $questiones->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Questiones', 'action' => 'delete', $questiones->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questiones->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>