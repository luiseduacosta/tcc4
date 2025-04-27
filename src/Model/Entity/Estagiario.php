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
 * @property int|null $professor_id
 * @property string $periodo
 * @property int|null $turmaestagio_id
 * @property float|null $nota
 * @property int|null $ch
 * @property string $ajuste2020
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Aluno[] $alunos
 * @property \App\Model\Entity\Professor[] $professores
 * @property \App\Model\Entity\Turmaestagio[] $turmaestagios
 * @property \App\Model\Entity\Supervisor[] $supervisores
 * @property \App\Model\Entity\Instituicao[] $instituicoes
 * @property \App\Model\Entity\Avaliacao[] $avaliacoes
 * @property \App\Model\Entity\Folhadeatividade[] $folhadeatividades
 * @property \App\Model\Entity\Tccestudante[] $tccestudantes
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
        'registro' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'instituicao_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'periodo' => true,
        'area_id' => true,
        'nota' => true,
        'ch' => true,
        'ajuste2020' => true,
        'observacoes' => true,
        'alunos' => true,
        'professores' => true,
        'turmaestagios' => true,
        'supervisores' => true,
        'instituicoes' => true,
        'avaliacoes' => true,
        'folhadeatividades' => true,
        'tccestudantes' => true
    ];
}
