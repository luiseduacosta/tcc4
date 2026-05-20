<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FolhadeatividadesFixture
 */
class FolhadeatividadesFixture extends TestFixture
{
    public string $table = 'folhadeatividades';
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
                'estagiario_id' => 1,
                'dia' => '2026-05-19',
                'inicio' => '22:53:06',
                'final' => '22:53:06',
                'atividade' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
