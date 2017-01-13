<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 11:31 AM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group" style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Cookie notice'), 'option-theme_cookie_notice', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">

        <p class="description">
            Cookie notice text that is displayed at page footer
        </p>

        <?= Html::textarea('Option[theme_cookie_notice][value]', $model->theme_cookie_notice->value, [
            'class' => 'form-control',
            'id' => 'option-theme_cookie_notice',
            'style'=> 'min-width: 932.5px; min-height: 190px;'
        ]) ?>

    </div>
</div>
    <div class="form-group">
        <?= Html::label(Yii::t('cms', 'Comply button'), 'option-theme_comply_button', ['class' => 'col-sm-2 control-label']) ?>

        <div class="col-sm-7">

            <?= Html::textInput('Option[theme_comply_button][value]', $model->theme_comply_button->value, [
                'class' => 'form-control',
                'id' => 'option-theme_comply_button',
            ]) ?>

            <p class="description">
                Enter comply button text e.g. "OK"
            </p>

        </div>

</div>
