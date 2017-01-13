<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use modules\slider\models\search\Slider;
use yii\helpers\Html;

/**
 * @var Slider[] $sliders
 */
foreach ($sliders as $slider) {
    echo Html::a(Html::img($slider->getImageUrl(), ['class' => 'img-responsive']),
        ['/slider/slider/index', 'id' => $slider->id],
        ['target' => '_blank']);
}