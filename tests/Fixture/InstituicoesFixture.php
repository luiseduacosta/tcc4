<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InstituicoesFixture
 */
class InstituicoesFixture extends TestFixture
{
    public string $table = 'estagio';
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
                'areainstituicoes_id' => 1,
                'area' => 1,
                'natureza' => 'Lorem ipsum dolor sit amet',
                'instituicao' => 'Lorem ipsum dolor sit amet',
                'cnpj' => '',
                'email' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'endereco' => 'Lorem ipsum dolor sit amet',
                'bairro' => 'Lorem ipsum dolor sit amet',
                'municipio' => 'Lorem ipsum dolor sit amet',
                'cep' => '',
                'telefone' => 'Lorem ipsum dolor sit amet',
                'fax' => 'Lorem ipsum dolor ',
                'beneficio' => 'Lorem ipsum dolor sit amet',
                'fim_de_semana' => '0',
                'localInscricao' => '0',
                'convenio' => 1,
                'expira' => '2026-05-19',
                'seguro' => '0',
                'avaliacao' => '3',
                'observacoes' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
