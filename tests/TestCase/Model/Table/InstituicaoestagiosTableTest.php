<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicaoestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicaoestagiosTable Test Case
 */
class InstituicaoestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InstituicaoestagiosTable
     */
    protected $InstituicaoestagiosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Instituicaoestagios',
        'app.Areainstituicoes',
        'app.Areaestagios',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Instituicaoestagios') ? [] : ['className' => InstituicaoestagiosTable::class];
        $this->InstituicaoestagiosTable = $this->getTableLocator()->get('Instituicaoestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InstituicaoestagiosTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\InstituicaoestagiosTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InstituicaoestagiosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\InstituicaoestagiosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
