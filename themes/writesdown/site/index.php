<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use frontend\widgets\RenderWidget;

/* @var $this yii\web\View */
/* @var $posts cms\models\Post[] */
/* @var $tags cms\models\Term[] */
/* @var $image cms\models\Media */
/* @var $pages yii\data\Pagination */
//$this->title = Html::encode(Option::get('sitetitle') . ' - ' . Option::get('tagline'));
?>
<?= RenderWidget::widget([
    'location' => 'homepage',
    'config' => [
        'beforeWidget' => '<div class="widget">',
        'afterWidget' => '</div>',
        'beforeTitle' => '<h4 class="widget-title header">',
        'afterTitle' => '</h4>',
    ]
]); ?>
<br/>
<?= $this->render('index-parts/posts',['posts'=>$posts,'pages'=>$pages]);?>

