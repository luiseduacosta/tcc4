<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AreainstituicoesFixture
 */
class AreainstituicoesFixture extends TestFixture
{
    public string $table = 'area_instituicoes';
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
