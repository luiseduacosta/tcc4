<?php
$usuario = $this->getRequest()->getAttribute('identity');
// echo 'Usuário: ' . $usuario->username;
// die();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMenuEsquerdo"
            aria-controls="navbarTogglerMenuEsquerdo" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerMenuEsquerdo">
        <ul class="navbar-nav mr-auto mt-lg-0">
            <li class = 'nav-item'><?= $this->Html->link(__('Agenda TCC'), ['controller' => 'Agendamentotccs', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class = 'nav-item'><?= $this->Html->link(__('Monografias'), ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'nav-link']) ?></li>

            <li class = 'nav-item'><?= $this->Html->link(__('Estudantes'), ['controller' => 'Tccestudantes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class = 'nav-item'><?= $this->Html->link(__('Docentes'), ['controller' => 'Docentes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class = 'nav-item'><?= $this->Html->link(__('Áreas'), ['controller' => 'Areamonografias', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class = 'nav-item'><?= $this->Html->link(__('Trajetórias'), ['controller' => 'Estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php if (isset($usuario) && !empty($usuario)): ?>
                <li class = 'nav-item'><?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link']) ?></li>
            <?php else: ?>
                <li class = 'nav-item'><?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
