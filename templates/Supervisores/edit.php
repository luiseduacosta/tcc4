<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <?=
                $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $supervisor->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id), 'class' => 'side-nav-item']
                )
                ?>
<?= $this->Html->link(__('List Supervisores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="supervisores form content">
                    <?= $this->Form->create($supervisor) ?>
                <fieldset>
                    <legend><?= __('Edit Supervisor') ?></legend>
                    <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('cress');
                    echo $this->Form->control('regiao');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('codigo_tel');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('codigo_cel');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('email');
                    echo $this->Form->control('escola');
                    echo $this->Form->control('ano_formatura');
                    echo $this->Form->control('outros_estudos');
                    echo $this->Form->control('area_curso');
                    echo $this->Form->control('ano_curso');
                    echo $this->Form->control('cargo');
                    echo $this->Form->control('num_inscricao');
                    echo $this->Form->control('curso_turma');
                    echo $this->Form->control('observacoes');
                    echo $this->Form->control('instituicaoestagios._ids', ['label' => ['text' => 'Instituição'],'options' => $instituicaoestagios]);
                    ?>
                </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>