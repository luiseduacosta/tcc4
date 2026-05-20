<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AreamonografiasFixture
 */
class AreamonografiasFixture extends TestFixture
{
    public string $table = 'areamonografias';
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
                'area' => 'Lorem ipsum dolor sit amet',
                'q_monografia' => 1,
            ],
        ];
        parent::init();
    }
}
