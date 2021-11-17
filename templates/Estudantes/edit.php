<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
$usuario = $this->getRequest()->getAttribute('identity');
?>
<div class='container'>
    <div class="row">
        <?php echo $this->element('menu_mural') ?>
        <?php if ($usuario->get('categoria') == 1): ?>
            <aside class="column">
                <div class="side-nav">
                    <h4 class="heading"><?= __('Ações') ?></h4>
                    <?=
                    $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $estudante->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $estudante->id), 'class' => 'side-nav-item']
                    )
                    ?>
                    <?= $this->Html->link(__('List Estudantes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
        <?php endif; ?>
        <div class="column-responsive column-80">
            <div class="estudantes form content">
                <?= $this->Form->create($estudante) ?>
                <fieldset>
                    <legend><?= __('Editar Estudante') ?></legend>
                    <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('registro');
                    echo $this->Form->control('codigo_telefone');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('codigo_celular');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('email');
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('identidade');
                    echo $this->Form->control('orgao');
                    echo $this->Form->control('nascimento', ['empty' => true]);
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>