<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Professor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $cpf
 * @property int|null $siape
 * @property string|null $cress
 * @property string|null $regiao
 * @property int|null $codigo_telefone
 * @property string|null $telefone
 * @property int|null $codigo_celular
 * @property string|null $celular
 * @property string|null $email
 * @property string|null $curriculolattes
 * @property \Cake\I18n\Date|null $atualizacaolattes
 * @property \Cake\I18n\Date|null $dataingresso
 * @property string|null $departamento
 * @property \Cake\I18n\Date|null $dataegresso
 * @property string|null $motivoegresso
 * @property string $status
 * @property string|null $observacoes
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\Monografia[] $monografias
 * @property \App\Model\Entity\User[] $users
 */
class Professor extends Entity
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
    protected array $_accessible = [
        'id' => false,
        'nome' => true,
        'cpf' => true,
        'siape' => true,
        'cress' => true,
        'regiao' => true,
        'codigo_telefone' => true,
        'telefone' => true,
        'codigo_celular' => true,
        'celular' => true,
        'email' => true,
        'curriculolattes' => true,
        'atualizacaolattes' => true,
        'dataingresso' => true,
        'departamento' => true,
        'dataegresso' => true,
        'motivoegresso' => true,
        'status' => true,
        'observacoes' => true,
        'user_id' => true,
        'monografias' => true,
        'users' => true,
    ];
}
