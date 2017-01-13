<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace themes\writesdown\classes\widgets;

use Yii;

/**
 * Class Nav
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class Nav extends \yii\bootstrap\Nav
{
    /**
     * @inheritdoc
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && $item['url'] === Yii::$app->request->absoluteUrl) {
            return true;
        }

        return false;
    }
}
