<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace themes\writesdown\classes\assets;

use yii\web\AssetBundle;

/**
 * Register asset files for WritesDown default theme.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class ThemeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\AppAssetIe9',
    ];

    public function init()
    {
        if (YII_DEBUG) {
            $this->css[] = 'css/site.css';
            $this->js[] = 'js/site.js';
            $this->js[] = 'js/demo.js';

        } else {
            $this->css[] = 'css/min/site.css';
            $this->js[] = 'js/min/site.js';
        }
    }
}
