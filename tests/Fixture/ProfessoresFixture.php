<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProfessoresFixture
 */
class ProfessoresFixture extends TestFixture
{
    public string $table = 'professores';
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
                'nome' => 'Maria da Silva',
                'cpf' => '123.456.789-00',
                'siape' => 1234567,
                'cress' => '123456/RJ',
                'regiao' => 'RJ',
                'codigo_telefone' => 21,
                'telefone' => '2222-3333',
                'codigo_celular' => 21,
                'celular' => '98888-7777',
                'email' => 'maria.silva@example.com',
                'curriculolattes' => '1234567890123456',
                'atualizacaolattes' => '2026-05-19',
                'dataingresso' => '2020-03-01',
                'departamento' => 'Fundamentos',
                'dataegresso' => null,
                'motivoegresso' => null,
                'status' => 'ativo',
                'observacoes' => 'Observações de teste.',
                'user_id' => null,
                'estagiarios_count' => 0,
            ],
        ];
        parent::init();
    }
}
