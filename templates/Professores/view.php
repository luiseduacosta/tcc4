<?php
declare(strict_types=1);
?>
<div class="container">
    <div class="col-auto mb-3">
        <?= $this->Html->link(__('Professores'), ['controller' => 'Professores', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <h3><?= h($professor->nome) ?></h3>
    <?php
    $statusLabels = [
        'ativo' => __('Ativo'),
        'aposentado' => __('Aposentado'),
        'inativo' => __('Inativo'),
    ];
    ?>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($professor->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($professor->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('CPF') ?></th>
                    <td><?= h($professor->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('SIAPE') ?></th>
                    <td><?= h($professor->siape) ?></td>
                </tr>
                <tr>
                    <th><?= __('CRESS') ?></th>
                    <td><?= h($professor->cress) ?></td>
                </tr>
                <tr>
                    <th><?= __('Região') ?></th>
                    <td><?= h($professor->regiao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= $professor->codigo_telefone ? '(' . h($professor->codigo_telefone) . ') ' : '' ?><?= h($professor->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= $professor->codigo_celular ? '(' . h($professor->codigo_celular) . ') ' : '' ?><?= h($professor->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Departamento') ?></th>
                    <td><?= h($professor->departamento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($professor->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currículo Lattes') ?></th>
                    <td><?= h($professor->curriculolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualização do Lattes') ?></th>
                    <td><?= h($professor->atualizacaolattes?->format('d/m/Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de Ingresso') ?></th>
                    <td><?= h($professor->dataingresso?->format('d/m/Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo de Cargo') ?></th>
                    <td><?= h($professor->tipocargo ?? '-') ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de Egresso') ?></th>
                    <td><?= h($professor->dataegresso?->format('d/m/Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo de Egresso') ?></th>
                    <td><?= h($professor->motivoegresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($statusLabels[$professor->status] ?? $professor->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td><?= $professor->observacoes ? nl2br(h($professor->observacoes)) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado') ?></th>
                    <td><?= h($professor->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modificado') ?></th>
                    <td><?= h($professor->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (!empty($professor->monografias)): ?>
    <div class="row mt-4">
        <div class="col">
            <h4><?= __('Monografias Associadas') ?></h4>
            <div class="table-responsive mt-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('Título') ?></th>
                            <th><?= __('Ano') ?></th>
                            <th class="text-nowrap"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($professor->monografias as $monografia): ?>
                            <tr>
                                <td><?= $this->Number->format($monografia->id) ?></td>
                                <td><?= h($monografia->titulo) ?></td>
                                <td><?= h($monografia->ano) ?></td>
                                <td class="text-nowrap">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Monografias', 'action' => 'view', $monografia->id], ['class' => 'btn btn-sm btn-info']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col">
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-warning']) ?>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>