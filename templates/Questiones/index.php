<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Questione> $questiones
 */
// pr($questiones);
?>

<?php echo $this->element("menu_mural"); ?>
<?php $this->element("templates"); ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Nova questão"),
                    ["action" => "add"],
                    [
                        "class" => "btn btn-primary",
                    ],
                ) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th><?= $this->Paginator->sort("id") ?></th>
                    <th><?= $this->Paginator->sort(
                        "questionario->title",
                        "Questionário",
                    ) ?></th>
                    <th><?= $this->Paginator->sort("text", "Texto") ?></th>
                    <th><?= $this->Paginator->sort("type", "Tipo") ?></th>
                    <th><?= $this->Paginator->sort("options", "Opções") ?></th>
                    <th><?= $this->Paginator->sort("ordem") ?></th>
                    <th><?= __("Ações") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questiones as $questione): ?>
                    <tr>
                        <td><?= $this->Number->format($questione->id) ?></td>
                        <td><?= $questione->has("questionario")
                            ? $this->Html->link(
                                $questione->questionario->title,
                                [
                                    "controller" => "Questionarios",
                                    "action" => "view",
                                    $questione->questionario->id,
                                ],
                            )
                            : "" ?>
                        </td>
                        <td><?= h($questione->text) ?></td>
                        <td><?= h($questione->type) ?></td>
                        <td>
                            <?php if ($questione->options) {
                                $opcoes = json_decode(
                                    $questione->options,
                                    true,
                                );
                                for (
                                    $i = 0;
                                    $i <= array_key_last($opcoes);
                                    $i++
                                ):
                                    if ($i === array_key_last($opcoes)):
                                        echo $opcoes[$i];
                                    else:
                                        echo $opcoes[$i] . ", ";
                                    endif;
                                endfor;
                            } ?>
                        </td>
                        <td><?= $questione->ordem === null
                            ? ""
                            : $this->Number->format($questione->ordem) ?></td>
                        <td class="table-info">
                            <?= $this->Html->link(__("Ver"), [
                                "action" => "view",
                                $questione->id,
                            ]) ?>
                            <?= $this->Html->link(__("Editar"), [
                                "action" => "edit",
                                $questione->id,
                            ]) ?>
                            <?= $this->Form->postLink(
                                __("Excluir"),
                                ["action" => "delete", $questione->id],
                                [
                                    "confirm" => __(
                                        "Are you sure you want to delete # {0}?",
                                        $questione->id,
                                    ),
                                ],
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first("<< " . __("first")) ?>
            <?= $this->Paginator->prev("< " . __("previous")) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__("next") . " >") ?>
            <?= $this->Paginator->last(__("last") . " >>") ?>
        </ul>
        <p><?= $this->Paginator->counter(
            __(
                "Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total",
            ),
        ) ?>
        </p>
    </div>
</div>
