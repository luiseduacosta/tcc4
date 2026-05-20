<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\EstagiariosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\EstagiariosController Test Case
 *
 * @link \App\Controller\EstagiariosController
 */
class EstagiariosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Estagiarios',
        'app.Alunos',
        'app.Professores',
        'app.Turmaestagios',
        'app.Supervisores',
        'app.Instituicoes',
        'app.Avaliacoes',
        'app.Respostas',
        'app.Folhadeatividades',
        'app.Tccestudantes',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test novotermocompromisso method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::novotermocompromisso()
     */
    public function testNovotermocompromisso(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test termodecompromissopdf method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::termodecompromissopdf()
     */
    public function testTermodecompromissopdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test declaracaodeestagiopdf method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::declaracaodeestagiopdf()
     */
    public function testDeclaracaodeestagiopdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test folhadeatividadespdf method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::folhadeatividadespdf()
     */
    public function testFolhadeatividadespdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test selecionaavaliacaodiscente method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::selecionaavaliacaodiscente()
     */
    public function testSelecionaavaliacaodiscente(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test avaliacaodiscentepdf method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::avaliacaodiscentepdf()
     */
    public function testAvaliacaodiscentepdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test lancanota method
     *
     * @return void
     * @link \App\Controller\EstagiariosController::lancanota()
     */
    public function testLancanota(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
