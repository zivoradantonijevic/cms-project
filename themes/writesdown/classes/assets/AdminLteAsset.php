<?php
/**
 * Project: goalserve
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 9.11.16.
 */

namespace themes\writesdown\classes\assets;


/**
 * AdminLteAsset
 **/
class AdminLteAsset extends \codezeen\yii2\adminlte\AdminLteAsset
{
    public $sourcePath = '@bower/adminlte/dist';
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
    ];
    public $js = [/*'js/app.min.js'*/];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'codezeen\yii2\fastclick\FastClickAsset',
    ];
}