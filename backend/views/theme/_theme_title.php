<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 10.10.16.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group" style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Site name'), 'option-theme_title', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_title][value]', $model->theme_title->value, [
            'class' => 'form-control',
            'id' => 'option-theme_title',
        ]) ?>

        <p class="description">
            Use %sitename% in Magazine Options to display site name in desired text fields.
        </p>
    </div>
</div>

