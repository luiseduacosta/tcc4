<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $usuario
 */
$usuario = $this->getRequest()->getAttribute('identity'); 
?>

<?php // pr($usuario->categoria);   ?>
<?php // die();   ?>
<nav class='navbar navbar-expand-lg navbar-light py-0 navbar-fixed-top'>
    <?= $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']); ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div style='font-size: 90%', class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">
            <?php
            if (isset($usuario) && $usuario->categoria == 1):
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Declarações</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/termodecompromisso?registro=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de avaliação discente", "/estagiarios/selecionaavaliacaodiscente/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Formulário de avaliação discente on-line", "/avaliacoes/index/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/estagiarios/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de atividades on-line", "/folhadeatividades/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Declaração de estágio", "/estagiarios/selecionadeclaracaodeestagio/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item']); ?>
                    </div>
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
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/Configuracao/view/1', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Usuários', '/userestagios/index', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/estudantes/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/estudantes/planilhacress/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Complemento período', '/Complementos/index/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Extensão', '/Extensaos/index/', ['class' => 'dropdown-item']); ?>
                    </div>
                </li>
            <?php endif; ?>
            <li class = "nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('TCC', ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'nav-link']); ?>
            </li>            
            <?php if (!(isset($usuario->categoria))): ?>
                <li class = "nav-item">
                    <?php echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], ['class' => 'nav-link']); ?>
                </li>
            <?php endif; ?>
        </ul>

        <ul class = "navbar-nav ml-auto">
            <?php
            if (isset($usuario->categoria)):
                switch ($usuario->categoria) {
                    case 1: // Administrador
                        ?>
                        <li class = "nav-item">
                            <?php echo $this->Html->link('Sair', '/users/logout/', ['class' => 'nav-link']); ?>
                        </li>
                        <?php
                        break;
                    case 2: // Estudante
                        $estagiario_id = $this->getRequest()->getSession()->read('estagiario_id');
                        ?>
                        <li class="nav-item">
                            <?php if ($estagiario_id): ?>
                                <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/termodecompromisso/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            <?php else: ?>
                                <?php echo $this->Html->link("Termo de compromisso", "/estudantes/view?registro=" . $usuario->numero, ['class' => 'nav-link']); ?>
                            <?php endif; ?>
                        </li>
                        <?php if ($estagiario_id): ?>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Declaração de estágio", "/estagiarios/selecionadeclaracaodeestagio/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Folha de atividades", "/estagiarios/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link("Preencher atividades on-line", "/folhadeatividades/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Avaliação discente", "/estagiarios/selecionaavaliacaodiscente/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Avaliação discente on-line", "/avaliacoes/index/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'nav-link']); ?>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Meus dados", "/estudantes/view?registro=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link']); ?>
                        </li>
                        <li class = "nav-item">
                            <?php echo $this->Html->link('Sair', '/users/logout/', ['class' => 'nav-link']); ?>
                        </li>
                        <?php
                        break;
                    case 3: // Professor
                        ?>
                        <?php if ($this->getRequest()->getSession()->read('estagiario') == 1): ?>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Notas e carga horária", "/Estagiarios/lancanota?siape=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link']); ?>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Meus dados", "/Professores/view?siape=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link']); ?>
                        </li>
                        <li class = "nav-item">
                            <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                        </li>
                        <?php
                        break;
                    case 4: // Supervisor
                        ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Avaliação discente", "/avaliacoes/supervisoravaliacao?cress=" . $this->getRequest()->getAttribute('identity')['numero'], ['class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Meus dados", "/Supervisores/view?cress=" . $this->getRequest()->getAttribute('identity')['numero'], ['class' => 'nav-link']); ?>
                        </li>
                        <li class = "nav-item">
                            <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                        </li>
                        <?php
                        break;
                    default:
                        ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Login", ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']); ?>
                        </li>
                    <?php
                }
            endif;
            ?>
        </ul>
    </div>
</nav>
