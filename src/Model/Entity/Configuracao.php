<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Configuracao Entity
 *
 * @property int $id
 * @property string $mural_periodo_atual
 * @property int $curso_turma_atual
 * @property \Cake\I18n\FrozenDate $curso_abertura_inscricoes
 * @property \Cake\I18n\FrozenDate $curso_encerramento_inscricoes
 * @property string $termo_compromisso_periodo
 * @property \Cake\I18n\FrozenDate $termo_compromisso_inicio
 * @property \Cake\I18n\FrozenDate $termo_compromisso_final
 */
class Configuracao extends Entity
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
        'mural_periodo_atual' => true,
        'curso_turma_atual' => true,
        'curso_abertura_inscricoes' => true,
        'curso_encerramento_inscricoes' => true,
        'termo_compromisso_periodo' => true,
        'termo_compromisso_inicio' => true,
        'termo_compromisso_final' => true,
    ];
}
