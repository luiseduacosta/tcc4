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
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => '',
                'password' => '',
                'categoria' => '1',
                'numero' => 1,
                'timestamp' => 1779241988,
                'estudante_id' => 1,
                'supervisor_id' => 1,
                'professor_id' => 1,
            ],
        ];
        parent::init();
    }
}
