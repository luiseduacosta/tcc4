<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvaliacoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvaliacoesTable Test Case
 */
class AvaliacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AvaliacoesTable
     */
    protected $AvaliacoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Avaliacoes',
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
        $config = $this->getTableLocator()->exists('Avaliacoes') ? [] : ['className' => AvaliacoesTable::class];
        $this->AvaliacoesTable = $this->getTableLocator()->get('Avaliacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AvaliacoesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AvaliacoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\AvaliacoesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
