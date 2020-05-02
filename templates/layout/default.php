<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">


        <!--
        Cake 4.0
        <?= $this->Html->css('milligram.min.css') ?>
        <?= $this->Html->css('cake.css') ?>
        -->

        <!--
        Cake 3.0
        -->
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('style.css') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?=
        $this->Html->script([
            'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'])
        ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <nav class="top-nav">
            <div class="top-nav-title">
                <center>
                    <a href="http://ess.ufrj.br/" target="_blank">
                        <img alt="Escola de Serviço Social - CFCH - UFRJ" src="http://ess.ufrj.br/templates/joomtic3/images/banner_logo.jpg" align='middle' width="70%" height="20%" />
                    </a>
                </center>
            </div>
            <div class="top-nav-links">
                <ul>
                    <?php $user = $this->getRequest()->getAttribute('identity'); ?>
                    <?php if (isset($user) && !empty($user)): ?>
                        <li class = 'button float-right'><?= 'Usuário: ' . $user->role ?></li>
                    <?php else: ?>
                        <li class = 'button float-right'><?= 'Usuário: ' . 'Visitante' ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <main class="main">
            <div class="container">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
</html>
