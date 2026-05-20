<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComplementosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComplementosTable Test Case
 */
class ComplementosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComplementosTable
     */
    protected $ComplementosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Complementos',
        'app.Estagiarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Complementos') ? [] : ['className' => ComplementosTable::class];
        $this->ComplementosTable = $this->getTableLocator()->get('Complementos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ComplementosTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ComplementosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ComplementosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
