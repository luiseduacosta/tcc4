<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AgendamentotccsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AgendamentotccsTable Test Case
 */
class AgendamentotccsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AgendamentotccsTable
     */
    protected $AgendamentotccsTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Agendamentotccs',
        'app.Estudantes',
        'app.Professores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Agendamentotccs') ? [] : ['className' => AgendamentotccsTable::class];
        $this->AgendamentotccsTable = $this->getTableLocator()->get('Agendamentotccs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AgendamentotccsTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AgendamentotccsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\AgendamentotccsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
