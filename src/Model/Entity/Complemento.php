<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Complemento Entity
 *
 * @property int $id
 * @property string|null $periodo_especial
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 */
class Complemento extends Entity
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
        'id' => true,
        'periodo_especial' => true,
        'estagiarios' => true,
    ];
}
