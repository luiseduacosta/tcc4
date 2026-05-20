<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConfiguracoesFixture
 */
class ConfiguracoesFixture extends TestFixture
{
    public string $table = 'configuracoes';
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
                'mural_periodo_atual' => '',
                'curso_turma_atual' => 1,
                'curso_abertura_inscricoes' => '2026-05-19',
                'curso_encerramento_inscricoes' => '2026-05-19',
                'termo_compromisso_periodo' => '',
                'termo_compromisso_inicio' => '2026-05-19',
                'termo_compromisso_final' => '2026-05-19',
                'periodo_calendario_academico' => '',
            ],
        ];
        parent::init();
    }
}
