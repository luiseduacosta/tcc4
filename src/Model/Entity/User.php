<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * Tabela compartilhada entre as aplicações do ess_apps. Os campos
 * `supervisor_id` e `professor_id` são usados pelo mural5 e devem ser
 * preservados mesmo quando o tcc5 não os utiliza.
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $nome
 * @property string|null $role
 * @property numeric|null $categoria
 * @property int|null $identificacao Registro do aluno, SIAPE do professor ou CRESS do supervisor
 * @property bool|null $ativo
 * @property int|null $aluno_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property \Cake\I18n\DateTime $criado_em
 * @property \Cake\I18n\DateTime $atualizado_em
 *
 * @property \App\Model\Entity\Estudante $estudante
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Professor $professor
 */
class User extends Entity
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
        'email' => true,
        'password' => true,
        'nome' => true,
        'role' => true,
        'categoria' => true,
        'identificacao' => true,
        'ativo' => true,
        'aluno_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'estudante' => true,
        'supervisor' => true,
        'professor' => true,
        'password_hash' => true,
    ];

    // Add this method

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return $password;
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        'password',
    ];
}
