<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estagiariomonografia Entity
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
 * @property int|null $professor_id
 * @property string $periodo
 * @property int|null $id_area
 * @property float|null $nota
 * @property int|null $ch
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Docente[] $docente
 * @property \App\Model\Entity\Estudante[] $estudante
 * @property \App\Model\Entity\Supervisor[] $supervisor
 * @property \App\Model\Entity\Instituicao[] $instituicao
 * @property \App\Model\Entity\Areaestagio[] $areaestagio
 * @property \App\Model\Entity\Avaliacao[] $avaliacao
 * @property \App\Model\Entity\Folhadeatividade[] $folhadeatividade
 * @property \App\Model\Entity\Tccestudante[] $tccestudante
 */
class Estagiariomonografia extends Entity
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
        'id_aluno' => true,
        'alunonovo_id' => true,
        'registro' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'id_instituicao' => true,
        'id_supervisor' => true,
        'id_professor' => true,
        'periodo' => true,
        'id_area' => true,
        'nota' => true,
        'ch' => true,
        'observacoes' => true,
        'complemento_id' => true,
        'ajuste2020' => true,
        'docente' => true,
        'estudante' => true,
        'supervisor' => true,
        'instituicao' => true,
        'areaestagio' => true,
        'avaliacao' => true,
        'folhadeatividade' => true,
        'tccestudante' => true
    ];
}
