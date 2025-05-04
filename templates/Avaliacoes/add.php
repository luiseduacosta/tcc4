<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario);
// die();
?>
<?php
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

$supervisora = isset($estagiario->supervisor->nome);
if ($supervisora) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

$regiao = isset($estagiario->supervisor->regiao);
if ($regiao) {
    $regiao = $estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

$cress = isset($estagiario->supervisor->cress);
if ($cress) {
    $cress = $estagiario->supervisor->cress;
} else {
    $cress = '_____';
}
?>

<style>
    legend {
        font-weight: normal;
        text-align: justify;
    }
</style>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAvaliacoes"
        aria-controls="navbarTogglerAvaliacoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerAvaliacoes">
        <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '4')): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index', '?' => $estagiario->id . '/' . $estagiario->registro], ['class' => 'btn btn-primary']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<h1>Formulário de avalição da(a) discente <?= $estagiario->aluno->nome ?></h1>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

        <?= $this->Form->create($avaliacao) ?>

        <fieldset>

            <?= $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]]); ?>

            <legend style="font-weight: normal;">1. ASSIDUIDADE</legend>
            <div class="row">
                <?= __('1) Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => true, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">2. PONTUALIDADE</legend>
            <div class="row">
                <?= __('2) Cumpre horário estabelecido no Plano de Estágio:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">3. COMPROMISSO</legend>
            <div class="row">
                <?= __('3) Cumpre com as ações e estratégias previstas no Plano de Estágio:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">4. RELACIONAMENTO COM O(A) USUÁRIO(A)</legend>
            <div class="row">
                <?= __('4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">5. INTEGRAÇÃO E ARTICULAÇÃO</legend>
            <div class="row">
                <?= __('5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">6. CRITICIDADE E INICATIVA</legend>
            <div class="row">
                <?= __('6) Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">7. APEENSÃO DO REFERENCIAL TEÓRICO-METODOLÓGICO, ÉTICO-POLÍTICO E INVESTIGATIVO E APLICAÇÃO NAS ATIVIDADES INERENTES AO CAMPO</legend>
            <div class="row">
                <?= __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">8. AVALIAÇÃO DO DESSEMPENHO DO(A) ESTAGIÁRIO(A) NA ELABORAÇÃO DE RELATÓRIOS, PESQUISAS, PROJETOS DE PESQUISA E INTERVENÇÃO, ETC:</legend>
                <?= __('8) Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
                </div>
            </div>
            
            <legend style="font-weight: normal;">9. AS ATIVIDADES PREVISTAS NO PLANO DE ESTÁGIO EM ARTECIAÇÃO COM O NÍVEL DE FORMAÇÃO ACADÊMICA FORAM EFETUADAS PLENAMENTE?</legend>
            <div class="row">
                <?= __('9) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
                </div>
            </div>
 
            <legend style="font-weight: normal;">Fundamente se achar necessário: </legend>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao9-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">10. O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?</legend>
                <?= __('10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">Justifique a resposta se achar necessário:</legend>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao10-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>
            
            <legend style="font-weight: normal;">11. Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?</legend>
                <?= __('11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">Como você avalia esta interação? (Responda se achar necessário)</legend>
            <div class="row">
                <div class="col-md-6">
            <?= $this->Form->input('avaliacao11-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">12. Você recebeu e acompanhou o programa da Disciplina OTP?</legend>
                <?= __('12) Você recebeu e acompanhou o programa da Disciplina OTP?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">Sugestões ao que foi desenvolvido?</legend>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao12-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">13. Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?</legend>
                <?= __('13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">Se sim, quais?</legend>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao13-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">14. Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre?</legend>
                <?= __('14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre?') ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>

            <legend style="font-weight: normal;">Sugestões e observações:</legend>
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
                </div>
            </div>

        </fieldset>
        <?= $this->Form->button(__('Submit', ['class' => 'btn btn-primary'])) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php
$this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js');
?>