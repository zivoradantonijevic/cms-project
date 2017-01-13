<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\Option */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="option-form">
    <?php $form = ActiveForm::begin(['id' => 'option-form']) ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => 64,
        'placeholder' => $model->getAttributeLabel('name'),
    ]) ?>

    <?= $form->field($model, 'value')->textarea([
        'rows' => 6,
        'placeholder' => $model->getAttributeLabel('value'),
    ]) ?>

    <?= $form->field($model, 'label')->textInput([
        'maxlength' => 64,
        'placeholder' => $model->getAttributeLabel('label'),
    ]) ?>

    <?= $form->field($model, 'group')->textInput([
        'maxlength' => 64,
        'placeholder' => $model->getAttributeLabel('group'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Save') : Yii::t('cms', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-flat btn-success' : 'btn btn-flat btn-primary',
        ]) ?>

    </div>
    <?php ActiveForm::end() ?>

</div>
