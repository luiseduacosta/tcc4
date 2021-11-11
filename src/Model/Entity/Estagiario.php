<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estagiario Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int $registro
 * @property string $turno
 * @property string $nivel
 * @property int $tc
 * @property \Cake\I18n\FrozenDate|null $tc_solicitacao
 * @property int $instituicao_id
 * @property int|null $supervisor_id
 * @property int|null $docente_id
 * @property string $periodo
 * @property int|null $id_area
 * @property float|null $nota
 * @property int|null $ch
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Docente $docente
 */
class Estagiario extends Entity
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
        'alunonovo_id' => true,
        'registro' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'instituicao_id' => true,
        'supervisor_id' => true,
        'docente_id' => true,
        'periodo' => true,
        'area_id' => true,
        'nota' => true,
        'ch' => true,
        'observacoes' => true,
        'aluno' => true,
        'estudante' => true,
        'instituicaoestagio' => true,
        'supervisor' => true,
        'docente' => true,
        'areaestagio' => true,
        'avaliacao' => true,
        'folhadeatividade' => true,            
    ];
}
