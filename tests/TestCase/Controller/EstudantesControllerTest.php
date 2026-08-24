<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\EstudantesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\EstudantesController Test Case
 *
 * @link \App\Controller\EstudantesController
 */
class EstudantesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Estudantes',
        'app.Muralinscricoes',
        'app.Estagiarios',
        'app.Agendamentotccs',
        'app.Tccestudantes',
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     * @link \App\Controller\EstudantesController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\EstudantesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }



    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\EstudantesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\EstudantesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\EstudantesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\EstudantesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
