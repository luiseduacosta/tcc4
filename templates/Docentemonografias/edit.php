<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li><?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $docentemonografia->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $docentemonografia->id)]
                )
                ?></li>
        <?php endif; ?>
        <?= $this->element('menu_monografias'); ?>
    </ul>
</nav>
<div class="docentes form large-9 medium-8 columns content">
    <?= $this->Form->create($docentemonografia) ?>
    <fieldset>
        <legend><?= __('Editar Docente') ?></legend>
        <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('cpf');
        echo $this->Form->control('siape');
        echo $this->Form->control('datanascimento', ['empty' => true]);
        echo $this->Form->control('localnascimento');
        echo $this->Form->control('sexo', ['options' => ['1' => 'Masculino', '2' => 'Feminino']]);
        echo $this->Form->control('ddd_telefone');
        echo $this->Form->control('telefone');
        echo $this->Form->control('ddd_celular');
        echo $this->Form->control('celular');
        echo $this->Form->control('email');
        echo $this->Form->control('homepage');
        echo $this->Form->control('redesocial');
        echo $this->Form->control('curriculolattes');
        echo $this->Form->control('atualizacaolattes', ['empty' => true]);
        echo $this->Form->control('curriculosigma');
        echo $this->Form->control('pesquisadordgp');
        echo $this->Form->control('formacaoprofissional');
        echo $this->Form->control('universidadedegraduacao');
        echo $this->Form->control('anoformacao');
        echo $this->Form->control('mestradoarea');
        echo $this->Form->control('mestradouniversidade');
        echo $this->Form->control('mestradoanoconclusao');
        echo $this->Form->control('doutoradoarea');
        echo $this->Form->control('doutoradouniversidade');
        echo $this->Form->control('doutoradoanoconclusao');
        echo $this->Form->control('dataingresso', ['empty' => true]);
        echo $this->Form->control('formaingresso');
        echo $this->Form->control('tipocargo');
        echo $this->Form->control('categoria');
        echo $this->Form->control('regimetrabalho');
        echo $this->Form->control('departamento', ['options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['empty' => true]);
        echo $this->Form->control('motivoegresso');
        echo $this->Form->control('observacoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
