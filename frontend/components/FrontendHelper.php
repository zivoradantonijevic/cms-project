<?php
/**
 * Project: goalserve
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 9.11.16.
 */
namespace frontend\components;

use Yii;

/**
 * FrontendHelper
 **/
class FrontendHelper
{
    public static function isHomepage()
    {
        $controller = Yii::$app->controller;
        return $controller->id == 'site' && $controller->action->id === 'index' ? true : false;
    }
}