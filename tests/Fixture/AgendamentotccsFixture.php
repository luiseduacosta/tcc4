<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AgendamentotccsFixture
 */
class AgendamentotccsFixture extends TestFixture
{
    public string $table = 'agendamentotccs';
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
                'estudante_id' => 1,
                'docente_id' => 1,
                'convidado' => 'Lorem ipsum dolor sit amet',
                'banca1' => 1,
                'banca2' => 1,
                'data' => '2026-05-19',
                'horario' => '22:53:05',
                'sala' => 'Lorem ipsum d',
                'titulo' => 'Lorem ipsum dolor sit amet',
                'avaliacao' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
