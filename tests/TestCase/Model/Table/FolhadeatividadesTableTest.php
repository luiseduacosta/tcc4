<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FolhadeatividadesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FolhadeatividadesTable Test Case
 */
class FolhadeatividadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FolhadeatividadesTable
     */
    protected $FolhadeatividadesTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Folhadeatividades',
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
        $config = $this->getTableLocator()->exists('Folhadeatividades') ? [] : ['className' => FolhadeatividadesTable::class];
        $this->FolhadeatividadesTable = $this->getTableLocator()->get('Folhadeatividades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FolhadeatividadesTable);

        parent::tearDown();
    }

    /**
     * Test beforeFind method
     *
     * @return void
     * @link \App\Model\Table\FolhadeatividadesTable::beforeFind()
     */
    public function testBeforeFind(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\FolhadeatividadesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\FolhadeatividadesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
