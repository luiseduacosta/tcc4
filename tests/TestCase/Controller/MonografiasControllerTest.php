<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MonografiasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MonografiasController Test Case
 *
 * @link \App\Controller\MonografiasController
 */
class MonografiasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Monografias',
        'app.Docentes',
        'app.Areamonografias',
        'app.Tccestudantes',
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     * @link \App\Controller\MonografiasController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\MonografiasController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\MonografiasController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\MonografiasController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\MonografiasController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\MonografiasController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test lista method
     *
     * @return void
     * @link \App\Controller\MonografiasController::lista()
     */
    public function testLista(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test verificapdf method
     *
     * @return void
     * @link \App\Controller\MonografiasController::verificapdf()
     */
    public function testVerificapdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test verificafilespdf method
     *
     * @return void
     * @link \App\Controller\MonografiasController::verificafilespdf()
     */
    public function testVerificafilespdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test download method
     *
     * @return void
     * @link \App\Controller\MonografiasController::download()
     */
    public function testDownload(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
