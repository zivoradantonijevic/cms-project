<?php

use dosamigos\datetimepicker\DateTimePicker;
use kartik\file\FileInput;
use modules\slider\models\SliderGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\Slider */
/* @var $form yii\widgets\ActiveForm */

$models = SliderGroup::find()->asArray()->all();
$map = ArrayHelper::map($models, 'id', 'name');
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],]); ?>
    <div class="row">
        <div class="col-md-8">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'group_id')->dropDownList($map, ['prompt' => 'Select Group']) ?>


            <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>

            <?php if($model->image):?>
            <img src="<?= $model->getImageUrl('image');?>">
            <?php endif;?>
            <?= $form->field($model, 'image')->widget(FileInput::className(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' => $model->image ? Yii::t('user', 'Change Image') : Yii::t('user', 'Upload Image'),
                    'previewFileType' => 'image',
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                ]
            ]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-title">Details</div>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'title_tr')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'subtitle_en')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'subtitle_tr')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'sortorder')->textInput() ?>

                    <?= $form->field($model, 'is_published')->checkbox() ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
