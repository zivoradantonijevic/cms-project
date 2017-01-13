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
/* @var $model cms\models\search\Module */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="module-search" class="collapse module-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'title') ?>

            <?= $form->field($model, 'description') ?>

            <?= $form->field($model, 'frontend_bootstrap')->dropDownList($model->getFrontendBootstraps(),
                ['prompt' => false]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->getStatuses(), ['prompt' => false]) ?>

            <?= $form->field($model, 'directory') ?>

            <?= $form->field($model, 'backend_bootstrap')->dropDownList($model->getBackendBootstraps(),
                ['prompt' => false]) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Search'), ['class' => 'btn btn-flat btn-primary']) ?>

        <?= Html::resetButton(Yii::t('cms', 'Reset'), ['class' => 'btn btn-flat btn-default']) ?>

        <?= Html::button(Html::tag('i', '', ['class' => 'fa fa fa-level-up']), [
            'class' => 'module-search-button btn btn-flat btn-default',
            'data-toggle' => 'collapse',
            'data-target' => '#module-search',
        ]) ?>

    </div>
    <?php ActiveForm::end() ?>

</div>
