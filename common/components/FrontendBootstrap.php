<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace common\components;

use cms\models\Module;
use cms\models\Option;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

/**
 * Class FrontendBootstrap
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class FrontendBootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $this->setTime($app);
        $this->setTheme($app);
        $this->setModule($app);
    }

    /**
     * Set time base on Option.
     *
     * @param Application $app the application currently running
     */
    protected function setTime($app)
    {
        /* TIME ZONE */
        $app->timeZone = Option::get('time_zone');

        /* DATE TIME */
        $app->formatter->dateFormat = 'php:' . Option::get('date_format');
        $app->formatter->timeFormat = 'php:' . Option::get('time_format');
        $app->formatter->datetimeFormat = 'php:' . Option::get('date_format') . ' ' . Option::get('time_format');
    }

    /**
     * Set theme params
     *
     * @param Application $app the application currently running
     */
    protected function setTheme($app)
    {
        $theme = Option::get('theme');
        $app->view->theme->basePath = '@themes/' . $theme;
        $app->view->theme->baseUrl = '@web/themes/' . $theme;

        $oldMap = $app->view->theme->pathMap;
        $newMap['@app/views'] = '@themes/' . $theme;
        foreach( $oldMap as $key=>$value){
            $newMap[$key] = str_replace('@app/views', '@themes/' . $theme, $value);
        }
        $app->view->theme->pathMap = $newMap;
        $paramsPath = Yii::getAlias('@themes/') . Option::get('theme') . '/config/params.php';

        if (is_file($paramsPath)) {
            $params = require($paramsPath);
            if ($frontendParams = ArrayHelper::getValue($params, 'frontend')) {
                $app->params = ArrayHelper::merge($app->params, $frontendParams);
            }
        }
    }

    /**
     * Set modules.
     *
     * @param Application $app the application currently running
     */
    protected function setModule($app)
    {
        foreach (Module::getActiveModules() as $module) {
            // Get module backend config.
            if ($config = $module->getFrontendConfig()) {
                // Set module.
                $app->setModules([$module->name => $config]);
                // Merge application params with exist module params.
                if (is_file($module->getParamPath())) {
                    $params = require($module->getParamPath());
                    if ($frontendParams = ArrayHelper::getValue($params, 'frontend')) {
                        $app->params = ArrayHelper::merge($app->params, $frontendParams);
                    }
                }
                // Bootstrap injection.
                if ($module->frontend_bootstrap) {
                    $component = $app->getModule($module->name);
                    if ($component instanceof BootstrapInterface) {
                        $component->bootstrap($app);
                    }
                }
            }
        }
    }
}
