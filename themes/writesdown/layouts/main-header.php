<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cebe\gravatar\Gravatar;
use cms\models\Menu;
use core\user\models\LoginForm;
use themes\writesdown\classes\widgets\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<header class="main-header">
    <a href="<?= Yii::$app->urlManagerFront->createUrl(['/']) ?>" class="logo">
        <span class="logo-mini"><?= Html::img(Yii::getAlias('@web/img/logo-mini.png')) ?></span>
        <span class="logo-lg"><?= Html::img(Yii::getAlias('@web/img/logo.png')) ?></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => Menu::get('primary'),
            'encodeLabels' => false,
        ]);

        ?>

    </nav>
</header>
