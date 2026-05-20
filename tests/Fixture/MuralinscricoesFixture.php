<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MuralinscricoesFixture
 */
class MuralinscricoesFixture extends TestFixture
{
    public string $table = 'inscricoes';
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
                'registro' => 1,
                'aluno_id' => 1,
                'muralestagio_id' => 1,
                'data' => '2026-05-19',
                'periodo' => '',
                'timestamp' => 1779241987,
                'alunoestagiario_id' => 1,
            ],
        ];
        parent::init();
    }
}
