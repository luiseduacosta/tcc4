<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstagiariomonografiasFixture
 */
class EstagiariomonografiasFixture extends TestFixture
{
    public string $table = 'estagiarios';
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
                'aluno_id' => 1,
                'alunoestagiario_id' => 1,
                'registro' => 1,
                'turno' => '',
                'nivel' => '',
                'tc' => 1,
                'tc_solicitacao' => '2026-05-19',
                'instituicao_id' => 1,
                'supervisor_id' => 1,
                'professor_id' => 1,
                'periodo' => 'Lore',
                'turmaestagio_id' => 1,
                'nota' => 1.5,
                'ch' => 1,
                'observacoes' => 'Lorem ipsum dolor sit amet',
                'complemento_id' => 1,
                'ajuste2020' => '',
                'benetransporte' => 1,
                'benealimentacao' => 1,
                'benebolsa' => 'Lor',
            ],
        ];
        parent::init();
    }
}
