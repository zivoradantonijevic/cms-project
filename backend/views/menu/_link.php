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
/* @var $selected cms\models\Menu */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'panel box box-primary create-menu-item',
        'data-url' => Url::to(['create-menu-item', 'id' => $selected->id]),
    ],
    'action' => Url::to(['/site/forbidden']),
]) ?>

<div class="box-header with-border">
    <h4 class="box-title">
        <a href="#link" data-parent="#create-menu-items" data-toggle="collapse" aria-expanded="true">
            <?= Yii::t('cms', 'Link Menu') ?>

        </a>
    </h4>
</div>
<div class="panel-collapse collapse in" id="link">
    <div class="box-body">
        <div class="form-group">
            <?= Html::label(Yii::t('cms', 'Menu Label'), 'item_label', ['class' => 'form-label']) ?>

            <?= Html::textInput('MenuItem[label]', null, [
                'class' => 'form-control',
                'placeholder' => 'Label',
                'maxlength' => '255',
                'id' => 'item_label',
            ]) ?>

        </div>
        <div class="form-group">
            <?= Html::label(Yii::t('cms', 'Menu URL'), 'item_url', ['class' => 'form-label']) ?>

            <?= Html::textInput('MenuItem[url]', null, [
                'class' => 'form-control',
                'placeholder' => 'URL',
                'maxlength' => '255',
                'id' => 'item_url',
            ]) ?>

        </div>
    </div>
    <div class="box-footer">
        <?= Html::hiddenInput('type', 'link') ?>

        <?= Html::submitButton(Yii::t('cms', 'Add Menu'), [
            'class' => 'btn btn-flat btn-primary btn-create-menu-item',
        ]) ?>

    </div>
</div>
<?php ActiveForm::end() ?>
