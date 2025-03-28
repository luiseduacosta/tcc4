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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!--
        Cake 4.0
        <?= $this->Html->css('milligram.min.css') ?>
        <?= $this->Html->css('cake.css') ?>
        -->

    <!--
        Cake 3.0

        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('style.css') ?>
        -->

    <!--
        Cake 4.0
        -->
    <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?=
        $this->Html->script([
            'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'
        ])
        ?>

    <!-- Include stylesheet -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" />
    <!-- Include the ckeditor library -->
    <script type="importmap">
            {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
                }
            }
        </script>

    <?= $this->fetch('script') ?>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMenu"
                aria-controls="navbarTogglerMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerMenu">
                <a href="http://ess.ufrj.br/" target="_blank">
                    <img alt="Escola de Serviço Social - CFCH - UFRJ"
                        src="http://ess.ufrj.br/templates/joomtic3/images/banner_logo.jpg" align='middle' width="70%"
                        height="20%" />
                </a>
            </div>
        </nav>

        <div class="btn btn-primary btn-sm float-end">
            <ul class='navbar-nav mr-auto mt-lg-0'>
                <?php $user = $this->getRequest()->getAttribute('identity'); ?>
                <?php if (isset($user) && !empty($user)): ?>
                    <li class='nav-item'><?= $user->email ?></li>
                <?php else: ?>
                    <li class='nav-item'><?= 'Visitante' ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <main class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
    <footer>
    </footer>
</body>

</html>