<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TccestudantesFixture
 */
class TccestudantesFixture extends TestFixture
{
    public string $table = 'tccestudantes';
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
                'nome' => 'Lorem ipsum dolor sit amet',
                'monografia_id' => 1,
                'registro' => '',
            ],
        ];
        parent::init();
    }
}
