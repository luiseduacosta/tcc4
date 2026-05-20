<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralinscricoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralinscricoesTable Test Case
 */
class MuralinscricoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuralinscricoesTable
     */
    protected $MuralinscricoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Muralinscricoes',
        'app.Alunos',
        'app.Muralestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Muralinscricoes') ? [] : ['className' => MuralinscricoesTable::class];
        $this->MuralinscricoesTable = $this->getTableLocator()->get('Muralinscricoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MuralinscricoesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MuralinscricoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MuralinscricoesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
