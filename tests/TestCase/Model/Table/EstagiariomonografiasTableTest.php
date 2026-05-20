<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstagiariomonografiasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstagiariomonografiasTable Test Case
 */
class EstagiariomonografiasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstagiariomonografiasTable
     */
    protected $EstagiariomonografiasTable;

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
        $config = $this->getTableLocator()->exists('Estagiariomonografias') ? [] : ['className' => EstagiariomonografiasTable::class];
        $this->EstagiariomonografiasTable = $this->getTableLocator()->get('Estagiariomonografias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstagiariomonografiasTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\EstagiariomonografiasTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EstagiariomonografiasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\EstagiariomonografiasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
