<?php
/**
 * Project: btool
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 26.10.16.
 */

namespace console\controllers;

use console\components\Mutex;
use yii\console\Controller;


/**
 * BaseController
 **/
class BaseController extends Controller
{
    /** @var  [] */
    protected $mutex;

    public function beforeAction($action)
    {
        $ret = parent::beforeAction($action);
        if (!$ret) {
            return false;
        }
        $this->mutex = [$this->id, $action->id];
        if (!Mutex::getMutex(get_class($this), $this->mutex)) {
            return false;
        }

        return $ret;
    }

    public function afterAction($action, $result)
    {
        $ret = parent::afterAction($action, $result);
        Mutex::releaseMutex(get_class($this), $this->mutex);
        return $ret;
    }

}