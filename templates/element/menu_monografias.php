<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
$usuario = $this->getRequest()->getAttribute('identity');
// echo 'Usuário: ' . $usuario->username;
// die();
?>

<nav class="navbar navbar-expand-lg navbar-light py-0 navbar-light bg-secondary navbar-fixed-top" id="actions-sidebar">
    <?= $this->Html->link("Monografias", ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'nav-link']); ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?= $this->Html->link(__('Agenda TCC'), ['controller' => 'Agendamentotccs', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Monografias'), ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <?php if (isset($usuario) && $usuario->categoria == 1): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Estudantes'), ['controller' => 'Tccestudantes', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Docentes'), ['controller' => 'Docentes', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Áreas'), ['controller' => 'Areamonografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Trajetórias'), ['controller' => 'Estagiariomonografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
            <?php endif; ?>
            <li class='nav-item'>
                <?= $this->Html->link(__('Mural'), ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <?php if (isset($usuario) && !empty($usuario)): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>