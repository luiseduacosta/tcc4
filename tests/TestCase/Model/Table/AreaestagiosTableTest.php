<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreaestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreaestagiosTable Test Case
 */
class AreaestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreaestagiosTable
     */
    protected $AreaestagiosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Areaestagios',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Instituicaoestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areaestagios') ? [] : ['className' => AreaestagiosTable::class];
        $this->AreaestagiosTable = $this->getTableLocator()->get('Areaestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AreaestagiosTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\AreaestagiosTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AreaestagiosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
