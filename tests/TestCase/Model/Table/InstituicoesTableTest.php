<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicoesTable Test Case
 */
class InstituicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InstituicoesTable
     */
    protected $InstituicoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Instituicoes',
        'app.Areainstituicoes',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Instituicoes') ? [] : ['className' => InstituicoesTable::class];
        $this->InstituicoesTable = $this->getTableLocator()->get('Instituicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InstituicoesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InstituicoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\InstituicoesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
