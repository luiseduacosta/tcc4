<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MonografiasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MonografiasTable Test Case
 */
class MonografiasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MonografiasTable
     */
    protected $Monografias;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Monografias',
        'app.Docentes',
        'app.CoOrientas',
        'app.Areas',
        'app.Tccestudantes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Monografias') ? [] : ['className' => MonografiasTable::class];
        $this->Monografias = TableRegistry::getTableLocator()->get('Monografias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Monografias);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
