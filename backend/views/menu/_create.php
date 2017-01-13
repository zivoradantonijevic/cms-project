<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model cms\models\Menu */
?>
<?php $form = ActiveForm::begin([
    'id' => 'create-menu-form',
    'action' => Url::to(['create']),
]) ?>

<div class="input-group">
    <?= $form->field($model, 'title', ['template' => '{input}'])->textInput([
        'placeholder' => $model->getAttributeLabel('title'),
    ]) ?>

    <div class="input-group-btn">
        <?= Html::submitButton(Yii::t('cms', 'Add New Menu'), ['class' => 'btn btn-flat btn-primary']) ?>

    </div>
</div>
<?php ActiveForm::end() ?>
