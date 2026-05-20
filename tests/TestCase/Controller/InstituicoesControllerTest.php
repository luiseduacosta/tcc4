<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InstituicoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InstituicoesController Test Case
 *
 * @link \App\Controller\InstituicoesController
 */
class InstituicoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Instituicoes',
        'app.Areainstituicoes',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buscasupervisores method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::buscasupervisores()
     */
    public function testBuscasupervisores(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buscainstituicao method
     *
     * @return void
     * @link \App\Controller\InstituicoesController::buscainstituicao()
     */
    public function testBuscainstituicao(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
