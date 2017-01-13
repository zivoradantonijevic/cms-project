<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use codezeen\yii2\tinymce\TinyMce;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model cms\models\MediaComment */
?>

<div class="post-comment-form">
    <?= $form->field($model, 'content', ["template" => "{input}\n{error}"])->widget(
        TinyMce::className(),
        [
            'compressorRoute' => 'editor/compressor',
            'settings' => [
                'menubar' => false,
                'skin_url' => Url::base(true) . '/editor/skins/writesdown',
                'toolbar_items_size' => 'medium',
                'toolbar' => 'bold | italic | strikethrough | underline | link | image | bullist | numlist',
            ],
            'options' => [
                'id' => 'mediacomment-content',
                'style' => 'height:200px;',
            ],
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Reply'), ['class' => 'btn-flat btn btn-primary']) ?>

    </div>
</div>
