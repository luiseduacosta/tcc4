<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestionariosTable Test Case
 */
class QuestionariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QuestionariosTable
     */
    protected $QuestionariosTable;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Questionarios',
        'app.Questiones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Questionarios') ? [] : ['className' => QuestionariosTable::class];
        $this->QuestionariosTable = $this->getTableLocator()->get('Questionarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->QuestionariosTable);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\QuestionariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
