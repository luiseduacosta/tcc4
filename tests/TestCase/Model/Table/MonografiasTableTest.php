<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MonografiasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MonografiasTable Test Case
 */
class MonografiasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MonografiasTable
     */
    protected $MonografiasTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Monografias',
        'app.Docentes',
        'app.Areamonografias',
        'app.Tccestudantes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Monografias') ? [] : ['className' => MonografiasTable::class];
        $this->MonografiasTable = $this->getTableLocator()->get('Monografias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MonografiasTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MonografiasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MonografiasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
