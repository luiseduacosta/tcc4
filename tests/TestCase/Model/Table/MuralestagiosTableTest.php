<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralestagiosTable Test Case
 */
class MuralestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuralestagiosTable
     */
    protected $MuralestagiosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Muralestagios',
        'app.Instituicoes',
        'app.Turmaestagios',
        'app.Professores',
        'app.Muralinscricoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Muralestagios') ? [] : ['className' => MuralestagiosTable::class];
        $this->MuralestagiosTable = $this->getTableLocator()->get('Muralestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MuralestagiosTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MuralestagiosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MuralestagiosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
