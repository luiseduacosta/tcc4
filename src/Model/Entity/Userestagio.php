<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
use Cake\ORM\Entity;

/**
 * Userestagio Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string $categoria
 * @property int $numero
 * @property int|null $estudante_id
 * @property int|null $supervisor_id
 * @property int|null $docente_id
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \App\Model\Entity\Estudante $estudante
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Docente $docente
 */
class Userestagio extends Entity {

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
        'email' => true,
        'password' => true,
        'categoria' => true,
        'numero' => true,
        'estudante_id' => true,
        'supervisor_id' => true,
        'docente_id' => true,
        'timestamp' => true,
        'role' => true,
        'estudante' => true,
        'supervisor' => true,
        'docente' => true
    ];

    // Add this method
    protected function _setPassword(string $password): ?string {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

}
