<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use modules\banner\models\search\Banner;
use yii\helpers\Html;

/**
 * @var Banner[] $banners
 */
foreach ($banners as $banner) {
    echo Html::a(Html::img($banner->getImageUrl(),['class'=>'img-responsive']), ['/banner/banner/index', 'id' => $banner->id],
        ['target' => '_blank']);
}