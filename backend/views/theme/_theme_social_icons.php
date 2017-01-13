<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 1:22 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Facebook'), 'option-theme_facebook_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_facebook_link][value]', $model->theme_facebook_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_facebook_link',
        ]) ?>

        <p class="description">
            Facebook link
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Twitter'), 'option-theme_twitter_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_twitter_link][value]', $model->theme_twitter_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_twitter_link',
        ]) ?>

        <p class="description">
            Twitter link
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Google+'), 'option-theme_googleplus_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_googleplus_link][value]', $model->theme_googleplus_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_googleplus_link',
        ]) ?>

        <p class="description">
            Google link
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'YouTube'), 'option-theme_yt_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_yt_link][value]', $model->theme_yt_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_yt_link',
        ]) ?>

        <p class="description">
            YouTube link
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Vimeo'), 'option-theme_vimeo_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_vimeo_link][value]', $model->theme_vimeo_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_vimeo_link',
        ]) ?>

        <p class="description">
            Vimeo link
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Instagram'), 'option-theme_instagram_link', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_instagram_link][value]', $model->theme_instagram_link->value, [
            'class' => 'form-control',
            'id' => 'option-theme_instagram_link',
        ]) ?>

        <p class="description">
            Instagram link
        </p>
    </div>
</div>