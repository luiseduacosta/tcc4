<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestoesTable Test Case
 */
class QuestoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QuestoesTable
     */
    protected $QuestoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Questoes',
        'app.Questionarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Questoes') ? [] : ['className' => QuestoesTable::class];
        $this->QuestoesTable = $this->getTableLocator()->get('Questoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->QuestoesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\QuestoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\QuestoesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
