<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use backend\assets\MediaAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\Media */

$this->title = Yii::t('cms', 'Add New Media');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

MediaAsset::register($this);
?>
<div class="media-create">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'media-upload',
            'data-url' => Url::to(['ajax-upload']),
        ],
        'action' => Url::to(['/site/forbidden']),
    ]) ?>

    <noscript><?= Html::hiddenInput('redirect', Url::to(['/site/forbidden'])) ?></noscript>
    <div class="dropzone fade">
        <div class="dropzone-inner">
            <?= Yii::t('cms', 'Drop files here') ?><br/>
            <?= Yii::t('cms', 'OR') ?><br/>
            <div class="btn btn-default btn-flat fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?= Yii::t('cms', 'Add files...') ?></span>
                <?= $form->field($model, 'file', [
                    'template' => '{input}',
                    'options' => ['class' => null],
                ])->fileInput(['multiple' => 'multiple']) ?>

            </div>
        </div>
    </div>
    <div role="presentation" class="media-container"></div>
    <?php ActiveForm::end() ?>

</div>
<?= $this->render('_template-create') ?>
