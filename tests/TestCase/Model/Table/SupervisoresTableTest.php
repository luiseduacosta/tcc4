<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupervisoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupervisoresTable Test Case
 */
class SupervisoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SupervisoresTable
     */
    protected $SupervisoresTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Supervisores',
        'app.Estagiarios',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('Supervisores') ? [] : ['className' => SupervisoresTable::class];
        $this->SupervisoresTable = $this->getTableLocator()->get('Supervisores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SupervisoresTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SupervisoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
