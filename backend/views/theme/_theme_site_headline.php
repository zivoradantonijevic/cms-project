<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 1:45 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Headline'), 'option-theme_site_headline_f', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_site_headline_f][value]', $model->theme_site_headline_f->value, [
            'class' => 'form-control',
            'id' => 'option-theme_site_headline_f',
        ]) ?>

        <p class="description">
            Headline
        </p>
    </div>
</div>
<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Highlighted part'), 'option-theme_small_headline', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?= Html::textInput('Option[theme_small_headline][value]', $model->theme_small_headline->value, [
            'class' => 'form-control',
            'id' => 'option-theme_small_headline',
        ]) ?>

        <p class="description">
            Words that need to be highlighted

        </p>
    </div>
</div>