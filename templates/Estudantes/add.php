<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
// pr($registro);
// die();
?>
<div class="container">
    <div class="row justify-content-center">
        <?php echo $this->element('menu_mural') ?>
    </div>
    <div class="row">
        <?= $this->Html->link(__('Listar estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="column-responsive column-80">
        <div class="estudantes form content">
            <?= $this->Form->create($estudante) ?>
            <fieldset>
                <legend><?= __('Cadastro de Estudante') ?></legend>
                <?php
                echo $this->Form->control('nome');
                if ($registro):
                    echo $this->Form->control('registro', ['value' => $registro, 'readonly']);
                else:
                    echo $this->Form->control('registro');
                endif;
                echo $this->Form->control('codigo_telefone');
                echo $this->Form->control('telefone');
                echo $this->Form->control('codigo_celular');
                echo $this->Form->control('celular');
                if ($email):
                    echo $this->Form->control('email', ['value' => $email, 'readonly']);
                else:
                    echo $this->Form->control('email');
                endif;
                echo $this->Form->control('cpf');
                echo $this->Form->control('identidade');
                echo $this->Form->control('orgao');
                echo $this->Form->control('nascimento', ['empty' => true]);
                echo $this->Form->control('cep');
                echo $this->Form->control('endereco');
                echo $this->Form->control('municipio');
                echo $this->Form->control('bairro');
                echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>