<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MuralestagiosFixture
 */
class MuralestagiosFixture extends TestFixture
{
    public string $table = 'mural_estagio';
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
                'instituicao_id' => 1,
                'instituicao' => 'Lorem ipsum dolor sit amet',
                'convenio' => '0',
                'vagas' => 1,
                'beneficios' => 'Lorem ipsum dolor sit amet',
                'final_de_semana' => '0',
                'cargaHoraria' => 1,
                'requisitos' => 'Lorem ipsum dolor sit amet',
                'turmaestagio_id' => 1,
                'horario' => '0',
                'professor_id' => 1,
                'dataSelecao' => '2026-05-19',
                'dataInscricao' => '2026-05-19',
                'horarioSelecao' => 'Lor',
                'localSelecao' => 'Lorem ipsum dolor sit amet',
                'formaSelecao' => '0',
                'contato' => 'Lorem ipsum dolor sit amet',
                'outras' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'periodo' => 'Lore',
                'datafax' => '2026-05-19',
                'localInscricao' => '0',
                'email' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
