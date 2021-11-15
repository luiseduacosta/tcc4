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

<div>
    <li><?= $this->Html->link(__('Agenda TCC'), ['controller' => 'Agendamentotccs', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Monografias'), ['controller' => 'Monografias', 'action' => 'index']) ?></li>
    <?php if (isset($usuario) && $usuario->categoria == 1): ?>
        <li><?= $this->Html->link(__('Estudantes'), ['controller' => 'Tccestudantes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Docentes'), ['controller' => 'Docentemonografias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Áreas'), ['controller' => 'Areamonografias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Trajetórias'), ['controller' => 'Estagiariomonografias', 'action' => 'index']) ?></li>
    <?php endif; ?>
    <?php if (isset($usuario) && !empty($usuario)): ?>
        <li><?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
    <?php else: ?>
        <li><?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?></li>
    <?php endif; ?>
</div>
