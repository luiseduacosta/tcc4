<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreainstituicoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreainstituicoesTable Test Case
 */
class AreainstituicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreainstituicoesTable
     */
    protected $AreainstituicoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Areainstituicoes',
        'app.Instituicoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areainstituicoes') ? [] : ['className' => AreainstituicoesTable::class];
        $this->AreainstituicoesTable = $this->getTableLocator()->get('Areainstituicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AreainstituicoesTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\AreainstituicoesTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AreainstituicoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
