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
/* @var $model yii\base\DynamicModel */
/* @var $errors array */

$this->title = Yii::t('cms', 'Upload New Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme">
    <div id="nav-tabs-custom" class="nav-tabs-custom">
        <?= $this->render('_navigation') ?>
        <div class="tab-content">
            <?php $form = ActiveForm::begin([
                'id' => 'theme-upload-form',
                'options' => ['enctype' => 'multipart/form-data'],
            ]) ?>

            <?= $form->field($model, 'file')->fileInput() ?>

            <?php foreach ($errors as $error): ?>
                <div class="help-block"><?= $error ?></div>
            <?php endforeach; ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('cms', 'Upload'), ['class' => 'btn btn-flat btn-primary']) ?>

            </div>
            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>
