<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ProfessoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Professores',
        'app.Monografias',
        'app.Users',
    ];

    protected function loginAs(string $categoria): void
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get(1);
        $user->categoria = $categoria;
        $this->session([
            'Auth' => $user,
        ]);
    }

    public function testIndexIsPublic(): void
    {
        $this->get('/professores');
        $this->assertResponseOk();
        $this->assertResponseContains('Maria da Silva');
        $this->assertResponseContains('João Souza');
    }

    public function testIndexStatusFilter(): void
    {
        $this->get('/professores?status=ativo');
        $this->assertResponseOk();
        $this->assertResponseContains('Maria da Silva');
        $this->assertResponseNotContains('João Souza');
    }

    public function testIndexStatusFilterAcceptsAlias(): void
    {
        $this->get('/professores?status=retired');
        $this->assertResponseOk();
        $this->assertResponseContains('João Souza');
        $this->assertResponseNotContains('Maria da Silva');
    }

    public function testViewIsPublic(): void
    {
        $professores = TableRegistry::getTableLocator()->get('Professores');
        $target = $professores->find()->first();

        $this->get('/professores/view/' . $target->id);
        $this->assertResponseOk();
        $this->assertResponseContains(h($target->nome));
        $this->assertResponseContains(h($target->cpf));
        $this->assertResponseContains(h($target->curriculolattes));
        $this->assertResponseContains($target->atualizacaolattes->format('d/m/Y'));
    }

    public function testAddRequiresLogin(): void
    {
        $this->get('/professores/add');
        $this->assertRedirectContains('/users/login');
    }

    public function testAddAsAdmin(): void
    {
        $this->loginAs('1');
        $this->enableCsrfToken();
        $this->post('/professores/add', [
            'nome' => 'Novo Docente',
            'email' => 'novo@example.com',
            'curriculolattes' => '9876543210987654',
            'atualizacaolattes' => '2026-02-10',
            'status' => 'ativo',
        ]);
        $this->assertRedirectContains('/professores/view');

        $professores = TableRegistry::getTableLocator()->get('Professores');
        $docente = $professores->find()->where(['nome' => 'Novo Docente'])->first();
        $this->assertNotNull($docente);
        $this->assertSame('ativo', $docente->status);
        $this->assertSame('9876543210987654', $docente->curriculolattes);
        $this->assertSame('2026-02-10', $docente->atualizacaolattes->format('Y-m-d'));
    }

    public function testAddKeepsAtivoWhenStatusEmpty(): void
    {
        $this->loginAs('1');
        $this->enableCsrfToken();
        $this->post('/professores/add', [
            'nome' => 'Docente Sem Status',
            'status' => '',
        ]);
        $this->assertRedirectContains('/professores/view');

        $professores = TableRegistry::getTableLocator()->get('Professores');
        $docente = $professores->find()->where(['nome' => 'Docente Sem Status'])->first();
        $this->assertNotNull($docente);
        $this->assertSame('ativo', $docente->status);
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAs('1');
        $this->enableCsrfToken();
        $professores = TableRegistry::getTableLocator()->get('Professores');
        $target = $professores->find()->first();

        $this->post('/professores/edit/' . $target->id, [
            'nome' => 'Nome Alterado',
            'status' => 'aposentado',
        ]);
        $this->assertRedirectContains('/professores/view/' . $target->id);

        $docente = $professores->get($target->id);
        $this->assertSame('Nome Alterado', $docente->nome);
        $this->assertSame('aposentado', $docente->status);
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAs('1');
        $this->enableCsrfToken();
        $professores = TableRegistry::getTableLocator()->get('Professores');
        $target = $professores->find()->orderBy(['id' => 'DESC'])->first();
        $id = $target->id;

        $this->post('/professores/delete/' . $id);
        $this->assertRedirectContains('/professores');

        $this->assertNull($professores->findById($id)->first());
    }

    public function testBuscaprofessor(): void
    {
        $this->enableCsrfToken();
        $this->post('/professores/buscaprofessor', [
            'nome' => 'Maria',
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('Maria da Silva');
    }
}
