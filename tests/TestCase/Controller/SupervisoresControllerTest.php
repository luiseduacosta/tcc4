<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\SupervisoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\SupervisoresController Test Case
 *
 * @link \App\Controller\SupervisoresController
 */
class SupervisoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Supervisores',
        'app.Estagiarios',
        'app.Users',
        'app.Instituicoes',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buscasupervisor method
     *
     * @return void
     * @link \App\Controller\SupervisoresController::buscasupervisor()
     */
    public function testBuscasupervisor(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
