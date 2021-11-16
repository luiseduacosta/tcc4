<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
// pr($estagiario);
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('observacoes')
</script>
<div class="row">
    <div class='container'>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1): ?>
                    <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Inserir Estagiario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'side-nav-item']) ?>
                <?php endif; ?>
                <?= $this->Html->link(__('Imprimir Termo de compromisso'), ['action' => 'termodecompromissopdf', $estagiario->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Preencher Folha de atividades'), ['controller' => 'folhadeatividades', 'action' => 'index', $estagiario->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Imprimir Folha de atividades'), ['action' => 'folhadeatividadespdf', $estagiario->id], ['class' => 'side-nav-item']) ?>
                <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1 || $this->getRequest()->getSession()->read('id_categoria') == 4): ?>
                    <?= $this->Html->link(__('Preencher Avaliação discente'), ['controller' => 'avaliacoes', 'action' => 'index', $estagiario->id], ['class' => 'side-nav-item']) ?>
                <?php endif; ?>
                <?= $this->Html->link(__('Imprimir Avaliação discente'), ['action' => 'avaliacaodiscentepdf', $estagiario->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Imprimir Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="estagiarios view content">
                <h3><?= h($estagiario->id) ?></h3>
                <table>
                    <tr>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $estagiario->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Registro') ?></th>
                        <td><?= $estagiario->registro ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Estudante') ?></th>
                        <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1): ?>
                            <td><?= $estagiario->has('estudante') ? $this->Html->link($estagiario->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $estagiario->estudante->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $estagiario->has('estudante') ? $estagiario->estudante->nome : '' ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Ajuste 2020') ?></th>
                        <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Turno') ?></th>
                        <td><?= h($estagiario->turno) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nível') ?></th>
                        <td><?= h($estagiario->nivel) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Instituição') ?></th>
                        <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1): ?>
                            <td><?= $estagiario->has('instituicaoestagio') ? $this->Html->link($estagiario->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiario->instituicaoestagio->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $estagiario->has('instituicaoestagio') ? $estagiario->instituicaoestagio->instituicao : '' ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Supervisor(a)') ?></th>
                        <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1): ?>
                            <td><?= $estagiario->has('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $estagiario->has('supervisor') ? $estagiario->supervisor->nome : '' ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Docente') ?></th>
                        <?php if ($this->getRequest()->getSession()->read('id_categoria') == 1): ?>
                            <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $estagiario->has('docente') ? $estagiario->docente->nome : '' ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Período') ?></th>
                        <td><?= h($estagiario->periodo) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Área de estágio') ?></th>
                        <td><?= $estagiario->has('areaestagio') ? $this->Html->link($estagiario->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $estagiario->areaestagio->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('TC') ?></th>
                        <td><?= $this->Number->format($estagiario->tc) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data TC') ?></th>
                        <td><?= $estagiario->tc_solicitacao ? $estagiario->tc_solicitacao : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nota') ?></th>
                        <td><?= $this->Number->format($estagiario->nota, ['places' => 2]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('CH') ?></th>
                        <td><?= $this->Number->format($estagiario->ch) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Observações') ?></th>
                        <td name = 'observacoes'><?= h($estagiario->observacoes) ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>