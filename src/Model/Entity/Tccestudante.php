<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tccestudante Entity
 *
 * @property string $nome
 * @property int $monografia_id
 * @property string|null $registro
 * 
 * @property \App\Model\Entity\Monografia[] $monografia
 * @property \App\Model\Entity\Aluno[] $aluno
 * @property \App\Model\Entity\Estudante[] $estudante
 * 
 */
class Tccestudante extends Entity
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
        'nome' => true,
        'monografia_id' => true,
        'registro' => true,
        'monografia' => true,
        'aluno' => true,
        'estudante' => true, // Para Monografias
    ];
}
