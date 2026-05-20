<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConfiguracoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConfiguracoesTable Test Case
 */
class ConfiguracoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConfiguracoesTable
     */
    protected $ConfiguracoesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Configuracoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Configuracoes') ? [] : ['className' => ConfiguracoesTable::class];
        $this->ConfiguracoesTable = $this->getTableLocator()->get('Configuracoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConfiguracoesTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ConfiguracoesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
