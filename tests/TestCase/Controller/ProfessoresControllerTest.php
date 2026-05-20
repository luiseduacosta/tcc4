<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProfessoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProfessoresController Test Case
 *
 * @link \App\Controller\ProfessoresController
 */
class ProfessoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Professores',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Users',
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buscaprofessor method
     *
     * @return void
     * @link \App\Controller\ProfessoresController::buscaprofessor()
     */
    public function testBuscaprofessor(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
