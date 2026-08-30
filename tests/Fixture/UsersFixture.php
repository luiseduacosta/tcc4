<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    public string $table = 'users';

    public array $fields = [
        'id' => ['type' => 'integer', 'autoIncrement' => true],
        'email' => ['type' => 'string', 'length' => 50, 'null' => true],
        'password' => ['type' => 'string', 'length' => 80, 'null' => true],
        'nome' => ['type' => 'string', 'length' => 128, 'null' => true],
        'role' => ['type' => 'string', 'null' => true],
        'categoria' => ['type' => 'string', 'null' => false, 'default' => '2'],
        'identificacao' => ['type' => 'integer', 'null' => true],
        'entidade_id' => ['type' => 'integer', 'null' => true],
        'ativo' => ['type' => 'boolean', 'default' => true],
        'aluno_id' => ['type' => 'integer', 'null' => true],
        'supervisor_id' => ['type' => 'integer', 'null' => true],
        'professor_id' => ['type' => 'integer', 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public array $records = [
        [
            'id' => 1,
            'email' => 'admin@example.com',
            'password' => 'secret',
            'nome' => 'Admin User',
            'role' => 'admin',
            'categoria' => '1',
            'identificacao' => 1234567,
            'entidade_id' => null,
            'ativo' => 1,
            'aluno_id' => null,
            'supervisor_id' => null,
            'professor_id' => 1,
        ],
    ];
}
