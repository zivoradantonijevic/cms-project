<?php

use dosamigos\datetimepicker\DateTimePicker;
use kartik\file\FileInput;
use modules\banner\models\BannerGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\banner\models\Banner */
/* @var $form yii\widgets\ActiveForm */

$models = BannerGroup::find()->asArray()->all();
$map = ArrayHelper::map($models, 'id', 'name');
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],]); ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'group_id')->dropDownList($map, ['prompt' => 'Select Group']) ?>

            <?= $form->field($model, 'sortorder')->textInput() ?>

            <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>

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

                    <?= $form->field($model, 'start_time')->widget(DateTimePicker::className(), [
                        'template' => '{reset}{button}{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'options' => [
                            'value' => $model->isNewRecord || !$model->start_time
                                ? date('M d, Y H:i:s')
                                : date('M d, Y H:i:s', strtotime($model->start_time)),
                        ],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'M dd, yyyy hh:ii:ss',
                            'todayBtn' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(), [
                        'template' => '{reset}{button}{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'options' => [
                            'value' => $model->isNewRecord || !$model->end_time
                                ? null
                                : date('M d, Y H:i:s', strtotime($model->end_time)),
                        ],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'M dd, yyyy hh:ii:ss',
                            'todayBtn' => true,
                        ],
                    ]) ?>

                    <?= $form ->field($model, 'impressions')->textInput() ?>

                    <?= $form ->field($model, 'clicks')->textInput() ?>



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
