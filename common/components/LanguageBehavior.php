<?php
/**
 * Project: goalserve
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 7.11.16.
 */

namespace common\components;

use yii\base\Behavior;


/**
 * LanguageBehavior
 **/
class LanguageBehavior extends Behavior
{
    public $attributes = ['title'];

    public function __get($name)
    {

        if (in_array($name, $this->attributes) && !isset($this->owner->$name)) {
            $field = $name . '_' . substr(\Yii::$app->language, 0, 2);
            return $this->owner->$field;
        }

        return parent::__get($name);
    }

    /**
     * Expose [[$translationAttributes]] readable
     *
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return in_array($name, $this->attributes) ? true : parent::canGetProperty($name, $checkVars);
    }
}