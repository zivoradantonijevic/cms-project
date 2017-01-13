<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cms\models\Option;
use cms\models\PostType;
use frontend\widgets\RenderWidget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?= RenderWidget::widget([
            'location' => 'sidebar-left',
            'config' => [
                'beforeWidget' => '<div class="widget">',
                'afterWidget' => '</div>',
                'beforeTitle' => '<h4 class="widget-title header">',
                'afterTitle' => '</h4>',
            ]
        ]); ?>
        <?= RenderWidget::widget([
            'location' => 'sidebar-left-2',
            'config' => [
                'beforeWidget' => '<div class="widget">',
                'afterWidget' => '</div>',
                'beforeTitle' => '<h4 class="widget-title header">',
                'afterTitle' => '</h4>',
            ]
        ]); ?>


    </section>
</aside>
