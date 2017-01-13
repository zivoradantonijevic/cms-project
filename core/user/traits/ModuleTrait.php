<?php


namespace core\user\traits;

use core\user\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package core\user\traits
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('user');
    }
}
