<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MonografiasFixture
 */
class MonografiasFixture extends TestFixture
{
    public string $table = 'monografias';

    public array $fields = [
        'id' => ['type' => 'integer', 'autoIncrement' => true],
        'catalogo' => ['type' => 'integer', 'null' => false, 'default' => 0],
        'titulo' => ['type' => 'string', 'length' => 160, 'null' => false],
        'resumo' => ['type' => 'text', 'null' => true],
        'data' => ['type' => 'date', 'null' => true],
        'periodo' => ['type' => 'string', 'length' => 6, 'null' => true],
        'professor_id' => ['type' => 'integer', 'null' => true],
        'num_co_orienta' => ['type' => 'integer', 'null' => true],
        'banca1' => ['type' => 'integer', 'null' => true],
        'banca2' => ['type' => 'integer', 'null' => true],
        'banca3' => ['type' => 'integer', 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public array $records = [];
}
