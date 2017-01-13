<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 16.9.16.
 */

namespace modules\slider\frontend\controllers;

use modules\slider\models\Slider;
use yii\web\Controller;


/**
 * SliderController
 **/
class SliderController extends Controller
{
    public function actionIndex($id)
    {
        $slider = Slider::findOne($id);
        if (!$slider || !$this->isSliderActive($slider)) {
            return $this->redirect(\Yii::$app->homeUrl);
        }
        /*$slider->clicks++;*/
        $slider->save();
        return $this->redirect($slider->url);
    }

    /**
     * @param Slider $slider
     *
     * @return bool
     */
    protected function isSliderActive($slider)
    {
        return $slider->is_published;
    }
}