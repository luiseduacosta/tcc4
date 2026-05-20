<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ComplementosFixture
 */
class ComplementosFixture extends TestFixture
{
    public string $table = 'complementos';
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
                'periodo_especial' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
