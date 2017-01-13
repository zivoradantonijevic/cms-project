<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */

$this->title = Yii::t('cms', 'Media Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-form">
    <?php $form = ActiveForm::begin(['id' => 'option-media-form', 'options' => ['class' => 'form-horizontal']]) ?>

    <h2><?= Yii::t('cms', 'Image sizes') ?></h2>

    <p>
        <?= Yii::t(
            'cms',
            'The sizes listed below determine the maximum dimensions in pixels to use when adding an image to the Media Library.'
        ) ?>

    </p>

    <div class="form-group">
        <?= Html::label(Yii::t('cms', 'Thumbnail size'), null, ['class' => 'col-sm-2 control-label']) ?>

        <div class="col-sm-7">
            <div class="checkbox">
                <?= Html::label(Yii::t('cms', 'Width'), null, ['style' => 'padding-left: 0']) ?>

                <?= Html::input(
                    'number',
                    'Option[thumbnail_width][value]',
                    $model->thumbnail_width->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?>

                <?= Html::label(Yii::t('cms', 'Height'), null, ['style' => 'padding-left: 0']) ?>
                <?= Html::input(
                    'number',
                    'Option[thumbnail_height][value]',
                    $model->thumbnail_height->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?><br/>

                <?= Html::label(
                    Html::checkbox(
                        'Option[thumbnail_crop][value]',
                        $model->thumbnail_crop->value,
                        ['uncheck' => 0]
                    ) . Yii::t('cms', 'Crop thumbnail to exact dimensions')
                ) ?>

            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::label(Yii::t('cms', 'Medium size'), null, ['class' => 'col-sm-2 control-label']) ?>

        <div class="col-sm-7">
            <div class="checkbox">
                <?= Html::label(Yii::t('cms', 'Max Width'), null, ['style' => 'padding-left: 0']) ?>

                <?= Html::input(
                    'number',
                    'Option[medium_width][value]',
                    $model->medium_width->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?>

                <?= Html::label(Yii::t('cms', 'Max Height'), null, ['style' => 'padding-left: 0']) ?>

                <?= Html::input(
                    'number',
                    'Option[medium_height][value]',
                    $model->medium_height->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?>

            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::label(Yii::t('cms', 'Large size'), null, ['class' => 'col-sm-2 control-label']) ?>

        <div class="col-sm-7">
            <div class="checkbox">
                <?= Html::label(Yii::t('cms', 'Max Width'), null, ['style' => 'padding-left: 0']) ?>

                <?= Html::input(
                    'number',
                    'Option[large_width][value]',
                    $model->large_width->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?>

                <?= Html::label(Yii::t('cms', 'Max Height'), null, ['style' => 'padding-left: 0']) ?>

                <?= Html::input(
                    'number',
                    'Option[large_height][value]',
                    $model->large_height->value,
                    ['min' => 0, 'step' => 1, 'style' => 'width: 70px']
                ) ?>

            </div>
        </div>
    </div>
    <h2><?= Yii::t('cms', 'Uploading Files') ?></h2>

    <div class="form-group">
        <?= Html::label(Yii::t('cms', 'Organizing files'), null, ['class' => 'col-sm-2 control-label']) ?>

        <div class="col-sm-7">
            <div class="checkbox">
                <?= Html::label(
                    Html::checkbox(
                        'Option[uploads_yearmonth_based][value]',
                        $model->uploads_yearmonth_based->value,
                        ['uncheck' => 0]
                    ) . Yii::t('cms', 'Organize my uploads into month- and year-based folders')
                ) ?>
                <br/>

                <?= Html::label(
                    Html::checkbox(
                        'Option[uploads_username_based][value]',
                        $model->uploads_username_based->value,
                        ['uncheck' => 0]
                    ) . Yii::t('cms', 'Organize my uploads into username-based folders')
                ) ?>

            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-flat btn-success']) ?>

        </div>
    </div>
    <?php ActiveForm::end() ?>

</div>
