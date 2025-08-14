<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Questione Entity
 *
 * @property int $id
 * @property int $questionario_id
 * @property string $text
 * @property string $type
 * @property string|null $options
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $order
 *
 * @property \App\Model\Entity\Questionario $questionario
 */
class Questione extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'questionario_id' => true,
        'text' => true,
        'type' => true,
        'options' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'questionario' => true,
    ];
}
