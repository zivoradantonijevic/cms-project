<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 16.9.16.
 */

namespace modules\banner\frontend\controllers;

use modules\banner\models\Banner;
use yii\web\Controller;


/**
 * BannerController
 **/
class BannerController extends Controller
{
    public function actionIndex($id)
    {
        $banner = Banner::findOne($id);
        if (!$banner || !$this->isBannerActive($banner)) {
            return $this->redirect(\Yii::$app->homeUrl);
        }
        $banner->clicks++;
        $banner->save();
        return $this->redirect($banner->url);
    }

    /**
     * @param Banner $banner
     *
     * @return bool
     */
    protected function isBannerActive($banner)
    {
        $now = date('Y-m-d H:i:s');
        if ($banner->start_time && $banner->start_time > $now) {
            return false;
        }
        if ($banner->end_time && $banner->end_time < $now) {
            return false;
        }
        return true;
    }
}