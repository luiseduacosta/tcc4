<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TurmaestagiosFixture
 */
class TurmaestagiosFixture extends TestFixture
{
    public string $table = 'turma_estagios';
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
