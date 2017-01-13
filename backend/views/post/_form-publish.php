<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('cms', 'Publish') ?></h3>

        <div class="box-tools pull-right">
            <a href="#" data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'date', ['template' => '{input}'])->widget(DateTimePicker::className(), [
            'size' => 'sm',
            'template' => '{reset}{button}{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'options' => [
                'value' => $model->isNewRecord
                    ? date('M d, Y H:i:s')
                    : date('M d, Y H:i:s', strtotime($model->date)),
            ],
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'M dd, yyyy hh:ii:ss',
                'todayBtn' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'status', ['template' => "{input}"])->dropDownList(
            Yii::$app->user->can('author') ? $model->getPostStatuses() : [$model::STATUS_REVIEW => 'Review'],
            ['class' => 'form-control input-sm']
        ) ?>

        <?= $form->field($model, 'password', ['template' => "{input}"])->textInput([
            'maxlength' => 255,
            'placeholder' => 'Password',
            'class' => 'form-control input-sm',
        ]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('cms', 'Publish'), ['class' => 'btn btn-sm btn-flat btn-primary']) ?>

        <?= !$model->isNewRecord
            ? Html::a(
                Yii::t('cms', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-wd-post btn-sm btn-flat btn-danger pull-right',
                    'data' => ['confirm' => Yii::t('cms', 'Are you sure you want to delete this item?')],
                ])
            : '' ?>

    </div>
</div>
