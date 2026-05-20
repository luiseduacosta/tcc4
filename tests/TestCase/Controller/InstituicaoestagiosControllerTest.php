<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InstituicaoestagiosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InstituicaoestagiosController Test Case
 *
 * @link \App\Controller\InstituicaoestagiosController
 */
class InstituicaoestagiosControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @link \App\Controller\InstituicaoestagiosController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\InstituicaoestagiosController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\InstituicaoestagiosController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\InstituicaoestagiosController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\InstituicaoestagiosController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
