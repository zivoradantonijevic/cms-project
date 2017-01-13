<?php

/*
 * This file is part of the Sport project.
 *
 * (c) Zivorad Antonijevic <http://github.com/zantonijevic/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace cms;

use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;


class Bootstrap implements BootstrapInterface
{


    /** @inheritdoc */
    public function bootstrap($app)
    {

        if (!isset($app->get('i18n')->translations['cms*'])) {
            $app->get('i18n')->translations['cms*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US'
            ];
        }

    }
}
