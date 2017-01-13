<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 1:43 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Copyright'), 'option-theme_copyright', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_copyright][value]', $model->theme_copyright->value, [
            'class' => 'form-control',
            'id' => 'option-theme_copyright',
        ]) ?>

        <p class="description">
            Copyright at footer
        </p>
    </div>
</div>