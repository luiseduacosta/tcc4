<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AreaestagiosFixture
 */
class AreaestagiosFixture extends TestFixture
{
    public string $table = 'areas_estagio';
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
            ],
        ];
        parent::init();
    }
}
