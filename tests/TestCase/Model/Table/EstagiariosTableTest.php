<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstagiariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstagiariosTable Test Case
 */
class EstagiariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstagiariosTable
     */
    protected $EstagiariosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Estagiarios',
        'app.Alunos',
        'app.Professores',
        'app.Turmaestagios',
        'app.Supervisores',
        'app.Instituicoes',
        'app.Avaliacoes',
        'app.Respostas',
        'app.Folhadeatividades',
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
        $config = $this->getTableLocator()->exists('Estagiarios') ? [] : ['className' => EstagiariosTable::class];
        $this->EstagiariosTable = $this->getTableLocator()->get('Estagiarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstagiariosTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\EstagiariosTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EstagiariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\EstagiariosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
