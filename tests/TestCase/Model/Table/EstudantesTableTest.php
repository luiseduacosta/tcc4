<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstudantesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstudantesTable Test Case
 */
class EstudantesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstudantesTable
     */
    protected $EstudantesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Estudantes',
        'app.Muralinscricoes',
        'app.Estagiarios',
        'app.Agendamentotccs',
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
        $config = $this->getTableLocator()->exists('Estudantes') ? [] : ['className' => EstudantesTable::class];
        $this->EstudantesTable = $this->getTableLocator()->get('Estudantes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstudantesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EstudantesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\EstudantesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
