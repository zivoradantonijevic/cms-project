<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\helpers\ArrayHelper;

/* @var $model cms\models\Post */
/* @var $postType cms\models\PostType */
/* @var $form yii\widgets\ActiveForm */

$metaBox = isset(Yii::$app->params['postType'][$postType->name]['meta'])
    ? Yii::$app->params['postType'][$postType->name]['meta']
    : [];

foreach ($metaBox as $config) {
    $config = ArrayHelper::merge($config, [
        'model' => $model,
        'form' => $form,
    ]);
    try {
        Yii::createObject($config);
    } catch (Exception $e) {
        // Hide errors
    }
}
