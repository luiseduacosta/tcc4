<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<div class="container">
    <div class="row justify-content-center">
        <?php echo $this->element('menu_mural') ?>
    </div>
    <div class="row">
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?=
        $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $muralestagio->id],
                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralestagio->id), 'class' => 'btn btn-danger']
        )
        ?>
    </div>
    <div class="column-responsive column-80">
        <div class="muralestagios form content">
            <?= $this->Form->create($muralestagio) ?>
            <fieldset>
                <legend><?= __('Editar Mural de estágio') ?></legend>
                <?php
                echo $this->Form->control('id_estagio', ['type' => 'hidden', 'label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => true, 'readonly']);
                echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição'], 'readonly']);
                echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                echo $this->Form->control('vagas');
                echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios']]);
                echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                echo $this->Form->control('cargaHoraria', ['label' => ['text' => 'Carga horária']]);
                echo $this->Form->control('requisitos');
                echo $this->Form->control('areaestagio_id', ['label' => ['text' => 'Área de estágio'], 'options' => $areaestagios]);
                echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Docente da OTP'], 'options' => $Professores]);
                echo $this->Form->control('dataSelecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
                echo $this->Form->control('dataInscricao', ['label' => ['text' => 'Data da inscrição'], 'empty' => true]);
                echo $this->Form->control('horarioSelecao', ['label' => ['text' => 'Horário da seleção']]);
                echo $this->Form->control('localSelecao', ['label' => ['text' => 'Local da seleção']]);
                echo $this->Form->control('formaSelecao', ['label' => ['text' => 'Forma da seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras']]);
                echo $this->Form->control('contato');
                echo $this->Form->control('email');
                echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'options' => $periodostotal]);
                echo $this->Form->control('datafax', ['empty' => true]);
                echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e na Coordenação de Estágio/ESS']]);
                echo $this->Form->control('outras', ['label' => ['text' => 'Outras informações']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
