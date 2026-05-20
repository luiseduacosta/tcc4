<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurmaestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TurmaestagiosTable Test Case
 */
class TurmaestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TurmaestagiosTable
     */
    protected $TurmaestagiosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Turmaestagios',
        'app.Estagiarios',
        'app.Muralestagios',
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
        $config = $this->getTableLocator()->exists('Turmaestagios') ? [] : ['className' => TurmaestagiosTable::class];
        $this->TurmaestagiosTable = $this->getTableLocator()->get('Turmaestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TurmaestagiosTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\TurmaestagiosTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TurmaestagiosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
