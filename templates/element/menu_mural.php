<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($user->categoria);
// die();   
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <div class="container-fluid">
        <?= $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'navbar-brand']); ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isset($user) && $user->categoria == 1): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Declarações
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->Html->link("Declaração de periódo", "/Alunos/certificadoperiodo/" . $user['aluno_id'], ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/novotermocompromisso?aluno_id=" . $user['aluno_id'], ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link("Declaração de estágio", "/estagiarios/selecionadeclaracaodeestagio/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?php echo $this->Html->link("Folha de avaliação discente", "/estagiarios/selecionaavaliacaodiscente/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link("Formulário de avaliação discente on-line", "/avaliacoes/index/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?php echo $this->Html->link("Folha de atividades", "/estagiarios/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link("Folha de atividades on-line", "/folhadeatividades/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Alunos", "/Alunos/index", ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Instituições", "/Instituicoes/index", ['escape' => FALSE, 'class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Professores", "/Professores/index/", ['class' => 'nav-link']); ?>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administração
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <?php echo $this->Html->link('Configuração', '/Configuracao/view/1', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Usuários', '/users/index', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Planilha seguro', '/alunos/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Planilha CRESS', '/alunos/planilhacress/', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Complemento período', '/Complementos/index/', ['class' => 'dropdown-item']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Extensão', '/Extensaos/index/', ['class' => 'dropdown-item']); ?>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '2'): ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/alunos/view/" . $user['aluno_id'], ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '3'): ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/professores/view/" . $user['professor_id'], ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '4'): ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/supervisores/view/" . $user['supervisor_id'], ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
                </li>
                <?php if (isset($user)): ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link('Sair', ['controller' => 'users', 'action' => 'logout'], ['class' => 'nav-link']); ?>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], ['class' => 'nav-link']); ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?php echo $this->Html->link('TCC', ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'btn btn-info']); ?>
                </li>
                <?php if (isset($user) && !empty($user)): ?>
                    <li class='nav-item'><span class="btn btn-primary"><?= $user->email ?></span></li>
                <?php else: ?>
                    <li class='nav-item'><span class="btn btn-secondary"><?= 'Visitante' ?></span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>