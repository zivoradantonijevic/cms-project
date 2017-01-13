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
    <?= Html::label(Yii::t('cms', 'Upload your site logo'), 'option-theme_logo',
        ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?php if ($model->theme_logo->value):
            $image = Html::img('/uploads/theme/' . $model->theme_logo->value, ['style' => "max-width:200px"]);
            ?>
            <?= Html::a($image, '/uploads/theme/' . $model->theme_logo->value, ['target' => '_blank']); ?>
        <?php endif; ?>
        <?= Html::fileInput('theme_logo_file', $model->theme_logo->value, [
            'class' => 'form-control',
            'id' => 'option-theme_logo',
        ]); ?>
        <?= Html::hiddenInput('Option[theme_logo][value]', $model->theme_logo->value, [
            'class' => 'form-control',
            'id' => 'option-theme_logo',
        ]) ?>

        <p class="description">
            Site logo that is displayed in upper part of each page
        </p>
    </div>

</div>

