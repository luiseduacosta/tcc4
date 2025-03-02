<?php
$user = $this->getRequest()->getAttribute('identity');
// pr($monografia['url']);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
?>

<div class="container">
    <div class="justify-content-start">
        <?= $this->element('menu_esquerdo') ?>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMonografiasEdit"
            aria-controls="navbarTogglerMonografiasEdit" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="collapse navbar-collapse list-unstyled" id="navbarTogglerMonografiasEdit">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li>
                    <?=
                        $this->Form->postLink(
                            __('Excluir Monografia'),
                            ['action' => 'delete', $monografia->id],
                            ['confirm' => __('Tem certeza que quer excluir a monografia # {0}?', $monografia->id), 'class' => 'btn btn-danger float-end']
                        )
                        ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php $this->element('templates'); ?>

    <div class="container">
        <?= $this->Form->create($monografia, ['type' => 'file']) ?>
        <fieldset>
            <legend><?= __('Editar monografia') ?></legend>
            <?php
            echo $this->Form->control('catalogo', ['type' => 'hidden']);
            echo $this->Form->textarea('titulo', ['rows' => '2', 'cols' => '50']);
            echo $this->Form->textarea('resumo', ['rows' => '5']);
            echo $this->Form->control('data ', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}'], 'empty' => TRUE]);
            echo $this->Form->control('periodo');
            echo $this->Form->control('docente_id', ['options' => $docentes, 'empty' => 'Seleciona docente']);
            echo $this->Form->control('co_orienta_id', ['label' => 'Co-orientador']);
            echo $this->Form->control('areamonografia_id', ['options' => $areas, 'empty' => 'Seleciona área']);
            echo $this->Form->control('data_defesa', ['type' => 'date', 'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}'], 'empty' => TRUE]);
            echo $this->Form->control('banca1', ['value' => $monografia->docente_id, 'options' => $docentes, 'empty' => true]);
            echo $this->Form->control('banca2', ['options' => $docentes, 'empty' => true]);
            echo $this->Form->control('banca3', ['options' => $docentes, 'empty' => true]);
            echo $this->Form->control('convidado');
            if (!empty($monografia['url'])):
                echo $this->Form->control('url_atual', ['label' => 'PDF atual', 'value' => $monografia['url']]);
                echo $this->Form->control('url', ['type' => 'file', 'label' => 'PDF novo', 'value' => $monografia['url']]);
            else:
                echo $this->Form->control('url', ['type' => 'file', 'label' => 'PDF novo', 'value' => $monografia['url']]);
            endif;
            echo $this->Form->control('timestamp', ['type' => 'hidden']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>