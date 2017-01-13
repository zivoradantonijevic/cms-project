<?php

namespace modules\slider\frontend;

use Yii;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'slider';
    /**
     * @var string
     */
    public $controllerNamespace = 'modules\slider\frontend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['slider'])) {
            Yii::$app->i18n->translations['slider'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => Yii::$app->language,
                'basePath'       => __DIR__ . '/../messages',
            ];
        }
    }
}
