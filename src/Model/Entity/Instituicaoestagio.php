<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Instituicaoestagio Entity
 *
 * @property int $id
 * @property string $instituicao
 * @property int|null $areainstituicoes_id
 * @property int|null $area
 * @property string|null $natureza
 * @property string $cnpj
 * @property string $email
 * @property string|null $url
 * @property string $endereco
 * @property string $bairro
 * @property string $municipio
 * @property string $cep
 * @property string $telefone
 * @property string $fax
 * @property string|null $beneficio
 * @property string|null $fim_de_semana
 * @property string $localInscricao
 * @property int $convenio
 * @property \Cake\I18n\FrozenDate|null $expira
 * @property string $seguro
 * @property string $avaliacao
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Areainstituicao $areainstituicao
 * @property \App\Model\Entity\Areainstituicao $areaestagio
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 * @property \App\Model\Entity\Visita[] $visitas
 * @property \App\Model\Entity\Supervisor[] $supervisores
 */
class Instituicaoestagio extends Entity
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
        'instituicao' => true,
        'area_instituicoes_id' => true,
        'area' => true,
        'natureza' => true,
        'cnpj' => true,
        'email' => true,
        'url' => true,
        'endereco' => true,
        'bairro' => true,
        'municipio' => true,
        'cep' => true,
        'telefone' => true,
        'fax' => true,
        'beneficio' => true,
        'fim_de_semana' => true,
        'localInscricao' => true,
        'convenio' => true,
        'expira' => true,
        'seguro' => true,
        'avaliacao' => true,
        'observacoes' => true,
        'areainstituicao' => true,
        'estagiarios' => true,
        'muralestagios' => true,
        'visitas' => true,
        'supervisores' => true,
    ];
}
