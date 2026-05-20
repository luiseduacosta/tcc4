<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocentesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocentesTable Test Case
 */
class DocentesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocentesTable
     */
    protected $DocentesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Docentes',
        'app.Users',
        'app.Monografias',
        'app.Areamonografias',
        'app.Agendamentotccs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Docentes') ? [] : ['className' => DocentesTable::class];
        $this->DocentesTable = $this->getTableLocator()->get('Docentes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocentesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\DocentesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\DocentesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
