<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>
<div class="container">
    <div class="row">
        <?php
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria == 1):
            ?>
            <aside class="column">
                <div class="side-nav">
                    <h4 class="heading"><?= __('Ações') ?></h4>
    <?= $this->Html->link(__('Listar usuários do mural de estagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
        <?php endif;
        ?>
        <div class="column-responsive column-80">
            <div class="userestagios form content">
<?= $this->Form->create($userestagio) ?>
                <fieldset>
                    <legend><?= __('Cadastro de novo usuário') ?></legend>
                    <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('password', ['label' => ['text' => 'Senha']]);
                    echo $this->Form->control('categoria', ['options' => ['2' => 'Estudante', '3' => 'Professor(a)', '4' => 'Supervisor']]);
                    echo $this->Form->control('numero', ['label' => ['text' => 'DRE, Siape ou Cress']]);
                    echo $this->Form->control('estudante_id', ['type' => 'hidden', 'options' => $estudantes, 'empty' => true]);
                    echo $this->Form->control('supervisor_id', ['type' => 'hidden', 'options' => $supervisores, 'empty' => true]);
                    echo $this->Form->control('docente_id', ['type' => 'hidden', 'options' => $docentes, 'empty' => true]);
                    echo $this->Form->control('timestamp', ['type' => 'hidden', date('Y-m-d')]);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
