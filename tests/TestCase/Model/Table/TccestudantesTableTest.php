<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TccestudantesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TccestudantesTable Test Case
 */
class TccestudantesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TccestudantesTable
     */
    protected $TccestudantesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Tccestudantes',
        'app.Monografias',
        'app.Estudantes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tccestudantes') ? [] : ['className' => TccestudantesTable::class];
        $this->TccestudantesTable = $this->getTableLocator()->get('Tccestudantes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TccestudantesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TccestudantesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TccestudantesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
