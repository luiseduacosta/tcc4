<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Agendamentotcc Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int $professor_id
 * @property int $banca1
 * @property int $banca2
 * @property \Cake\I18n\FrozenDate $data
 * @property \Cake\I18n\FrozenTime $horario
 * @property int $sala
 * @property string $convidado
 * @property string $titulo
 * @property string $avaliacao
 *
 * @property \App\Model\Entity\Aluno[] $aluno
 * @property \App\Model\Entity\Professor[] $professor
 * @property \App\Model\Entity\Professor[] $professorbanca1
 * @property \App\Model\Entity\Professor[] $professorbanca2
 */
class Agendamentotcc extends Entity
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
        'aluno_id' => true,
        'professor_id' => true,
        'banca1' => true,
        'banca2' => true,
        'data' => true,
        'horario' => true,
        'sala' => true,
        'convidado' => true,
        'titulo' => true,
        'avaliacao' => true,
        'aluno' => true,
        'professor' => true,
        'professorbanca1' => true,
        'professorbanca2' => true,
    ];
}
