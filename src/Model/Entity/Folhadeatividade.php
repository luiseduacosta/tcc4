<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folhadeatividade Entity
 *
 * @property int $id
 * @property int $estagiario_id
 * @property \Cake\I18n\FrozenDate $dia
 * @property \Cake\I18n\FrozenTime $inicio
 * @property \Cake\I18n\FrozenTime $final
 * @property \Cake\I18n\FrozenTime|null $horario
 * @property string $atividade
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 */
class Folhadeatividade extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'estagiario_id' => true,
        'dia' => true,
        'inicio' => true,
        'final' => true,
        'horario' => true,
        'atividade' => true,
        'estagiarios' => true,
    ];
}
