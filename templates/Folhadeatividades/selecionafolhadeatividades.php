<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliaco[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario->item->estudante);
// die();
?>

<?php echo $this->element('menu_mural') ?>

<h3><?= __('Estágios cursados pela(o) estudande ') ?></h3>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Preenche atividades') ?></th>
                <th><?= $this->Paginator->sort('estagiario->estudante->nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('estagiario->instituicaoestagio->instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                    <th class="actions"><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiario as $c_estagiario): ?>
                <?php // pr($c_estagiario); ?>
                <?php // die(); ?>
                <tr>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                        <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                    <?php endif; ?>

                    <td><?= $this->Html->link('Preencher folha de atividades', ['controller' => 'folhadeatividades', 'action' => 'index', $c_estagiario->id], ['class' => 'btn btn-success']) ?></td>

                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                        <td><?= $c_estagiario->has('estudante') ? $this->Html->link($c_estagiario->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $c_estagiario->estudante->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= $c_estagiario->has('estudante') ? $c_estagiario->estudante->nome : '' ?></td>
                    <?php endif; ?>

                    <td><?= $c_estagiario->periodo ?></td>
                    <td><?= $c_estagiario->nivel ?></td>
                    <td><?= $c_estagiario->has('instituicaoestagio') ? $c_estagiario->instituicaoestagio->instituicao : '' ?></td>
                    <td><?= $c_estagiario->has('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                    <td><?= $c_estagiario->ch ?></td>
                    <td><?= $c_estagiario->nota ?></td>

                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?> 
                        <?php if (isset($c_estagiario->id)): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $c_estagiario->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $c_estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $c_estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $c_estagiario->id)]) ?>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

