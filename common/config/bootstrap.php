<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('modules', dirname(dirname(__DIR__)) . '/modules');
Yii::setAlias('widgets', dirname(dirname(__DIR__)) . '/widgets');
Yii::setAlias('themes', dirname(dirname(__DIR__)) . '/themes');
Yii::setAlias('public', dirname(dirname(__DIR__)) . '/public');
Yii::setAlias('core', dirname(dirname(__DIR__)) . '/core');
Yii::setAlias('cms', dirname(dirname(__DIR__)) . '/cms');

require_once __DIR__ . '/../helpers/helper.php';