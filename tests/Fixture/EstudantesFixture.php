<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstudantesFixture
 */
class EstudantesFixture extends TestFixture
{
    public string $table = 'alunos';
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
                'nome' => 'Lorem ipsum dolor sit amet',
                'nomesocial' => 'Lorem ipsum dolor sit amet',
                'ingresso' => '',
                'turno' => 'Lorem',
                'registro' => 1,
                'codigo_telefone' => 1,
                'telefone' => 'Lorem ipsum d',
                'codigo_celular' => 1,
                'celular' => 'Lorem ipsum d',
                'email' => 'Lorem ipsum dolor sit amet',
                'cpf' => 'Lorem ipsum ',
                'identidade' => 'Lorem ipsum d',
                'orgao' => 'Lorem ipsum dolor sit amet',
                'nascimento' => '2026-05-19',
                'endereco' => 'Lorem ipsum dolor sit amet',
                'cep' => 'Lorem i',
                'municipio' => 'Lorem ipsum dolor sit amet',
                'bairro' => 'Lorem ipsum dolor sit amet',
                'observacoes' => 'Lorem ipsum dolor sit amet',
                'estagiario_count' => 1,
                'inscricao_count' => 1,
            ],
        ];
        parent::init();
    }
}
