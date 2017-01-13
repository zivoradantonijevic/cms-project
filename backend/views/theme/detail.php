<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $theme [] */
/* @var $installed string */

$this->title = Yii::t('cms', 'Detail Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $theme['info']['Name'];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_theme-detail', [
    'theme' => $theme,
    'installed' => $installed,
]);
