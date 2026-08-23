<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreamonografiasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreamonografiasTable Test Case
 */
class AreamonografiasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreamonografiasTable
     */
    protected $AreamonografiasTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Areamonografias',
        'app.Monografias',
        'app.Professores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areamonografias') ? [] : ['className' => AreamonografiasTable::class];
        $this->AreamonografiasTable = $this->getTableLocator()->get('Areamonografias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AreamonografiasTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AreamonografiasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
