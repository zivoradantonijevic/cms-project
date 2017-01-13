<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 12:52 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group" style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Show Splash'), 'option-theme_show_splash', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-7">
        <div class="checkbox">
            <?= Html::label(
                Html::checkbox(
                    'Option[theme_show_splash][value]',
                    $model->theme_show_splash->value === 'open' ? true : false, [
                        'uncheck' => 'close',
                        'value' => 'open',
                    ]
                ) . Yii::t('cms', 'Show Splash Screen')
            ) ?>

        </div>
    </div>

</div>
<div class="form-group">
    <?= Html::label(Yii::t('cms', 'Upload your landing page splash image'), 'option-theme_splash_image', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?php if ($model->theme_splash_image->value):
            $image = Html::img('/uploads/theme/' . $model->theme_splash_image->value, ['style' => "max-width:200px"]);
            ?>
            <?= Html::a($image, '/uploads/theme/' . $model->theme_splash_image->value, ['target' => '_blank']); ?>
        <?php endif; ?>
        <?= Html::fileInput('theme_splash_image_file', $model->theme_splash_image->value, [
            'class' => 'form-control',
            'id' => 'option-theme_splash_image',
        ]); ?>
        <?= Html::hiddenInput('Option[theme_splash_image][value]', $model->theme_splash_image->value, [
            'class' => 'form-control',
            'id' => 'option-theme_splash_image',
        ]) ?>

        <p class="description">
            Background image that will be shown on landing page
        </p>
    </div>

</div>
<div class="form-group">
    <?= Html::label(Yii::t('cms', 'Splash page text'), 'option-theme_splash_text', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_splash_text][value]', $model->theme_splash_text->value, [
            'class' => 'form-control',
            'id' => 'option-theme_splash_text',
        ]) ?>

        <p class="description">
            Splash page text
        </p>
    </div>
</div>
<div class="form-group">
    <?= Html::label(Yii::t('cms', 'Gray button text'), 'option-theme_gray_button', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_gray_button][value]', $model->theme_gray_button->value, [
            'class' => 'form-control',
            'id' => 'option-theme_gray_button',
        ]) ?>

        <p class="description">
            Enter desired button text e.g "Leave"
        </p>
    </div>
</div>
<div class="form-group">
    <?= Html::label(Yii::t('cms', 'Gray button URL'), 'option-theme_button_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_button_link][value]', $model->theme_button_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_button_link',
        ]) ?>

        <p class="description">
            Enter desired URL for the button above.
        </p>
    </div>
</div>
<div class="form-group">
    <?= Html::label(Yii::t('cms', 'Green button text'), 'option-theme_green_button', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_green_button][value]', $model->theme_green_button->value, [
            'class' => 'form-control',
            'id' => 'option-theme_green_button',
        ]) ?>

        <p class="description">
            Enter desired button text e.g "Come in and have Fun"
        </p>
    </div>
</div>

