<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SupervisoresFixture
 */
class SupervisoresFixture extends TestFixture
{
    public string $table = 'supervisores';
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
                'cpf' => 'Lorem ipsum ',
                'endereco' => 'Lorem ipsum dolor sit amet',
                'bairro' => 'Lorem ipsum dolor sit amet',
                'municipio' => 'Lorem ipsum dolor sit amet',
                'cep' => 'Lorem i',
                'codigo_tel' => '',
                'telefone' => 'Lorem ipsum d',
                'codigo_cel' => '',
                'celular' => 'Lorem ipsum d',
                'email' => 'Lorem ipsum dolor sit amet',
                'escola' => 'Lorem ipsum dolor sit amet',
                'ano_formatura' => 'Lo',
                'cress' => 1,
                'regiao' => 1,
                'outros_estudos' => 'Lorem ipsum dolor sit amet',
                'area_curso' => 'Lorem ipsum dolor sit amet',
                'ano_curso' => 'Lo',
                'cargo' => 'Lorem ipsum dolor sit a',
                'num_inscricao' => 1,
                'curso_turma' => '',
                'observacoes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
