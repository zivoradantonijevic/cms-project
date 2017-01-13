<?php

namespace modules\banner\frontend;

use Yii;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'banner';
    /**
     * @var string
     */
    public $controllerNamespace = 'modules\banner\frontend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['banner'])) {
            Yii::$app->i18n->translations['banner'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => Yii::$app->language,
                'basePath'       => __DIR__ . '/../messages',
            ];
        }
    }
}
