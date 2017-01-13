<?php
/**
 * Project: carcraft
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 9.10.15.
 */

namespace console\components;

use Yii;
use yii\mutex\FileMutex;


/**
 * Mutex
 **/
class Mutex
{
    /**
     * @param string $key
     * @param mixed  $entry
     *
     * @return bool
     */
    public static function getMutex($key, $entry)
    {
        /** @var FileMutex $mutex */
        $mutex = Yii::$app->mutex;
        $mutexName = self::getMutexName($key, $entry);

        return $mutex->acquire($mutexName);
    }

    /**
     * @param string $key
     * @param mixed  $entry
     */
    public static function releaseMutex($key, $entry)
    {
        /** @var FileMutex $mutex */
        $mutex = Yii::$app->mutex;
        $mutexName = self::getMutexName($key, $entry);

        $mutex->release($mutexName);
    }

    /**
     * @param string $key
     * @param mixed  $entry
     *
     * @return string
     */
    protected function getMutexName($key, $entry)
    {
        return $key . '-' . (isset($entry->id) ? $entry->id : md5(serialize($entry)));
    }
}