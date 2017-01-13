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
/* @var $model cms\models\search\Option */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="option-search" class="option-search collapse">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'value') ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'label') ?>

            <?= $form->field($model, 'group') ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Search'), ['class' => 'btn btn-flat btn-primary']) ?>

        <?= Html::resetButton(Yii::t('cms', 'Reset'), ['class' => 'btn btn-flat btn-default']) ?>

        <?= Html::button(Html::tag('i', '', ['class' => 'fa fa fa-level-up']), [
            'class' => 'index-search-button btn btn-flat btn-default',
            'data-toggle' => 'collapse',
            'data-target' => '#option-search',
        ]) ?>

    </div>
    <?php ActiveForm::end() ?>

</div>
