<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use cms\models\Option;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $post cms\models\Post */
/* @var $model cms\models\PostComment */
?>
<div id="respond" class="post-comment-form">
    <h3 class="reply-title"><?= Yii::t('cms', 'Leave a Reply') ?></h3>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Yii::t('cms', 'Login as {username}, {logout}{cancelReply}', [
                'username' => '<strong>' . Yii::$app->user->identity->username . '</strong>',
                'logout' => Html::a(Yii::t(
                    'cms', '<strong>Sign Out</strong>'),
                    ['/site/logout'],
                    ['data-method' => 'post']
                ),
                'cancelReply' => Html::a('<strong>' . Yii::t('cms', ', Cancel Reply') . '</strong>', '#', [
                    'id' => 'cancel-reply',
                    'class' => 'cancel-reply',
                    'style' => 'display:none;',
                ]),
            ]) ?>
        </p>
    <?php else: ?>
        <p>
            <?= Html::a('<strong>' . Yii::t('cms', 'Cancel Reply') . '</strong>', '#', [
                'id' => 'cancel-reply',
                'class' => 'cancel-reply',
                'style' => 'display:none;',
            ]) ?>
        </p>
    <?php endif ?>

    <?php $form = ActiveForm::begin() ?>

    <?php if (Yii::$app->user->isGuest && Option::get('require_name_email')): ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'author')->textInput() ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

                <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

            </div>
        </div>
    <?php endif ?>

    <?= Html::activeHiddenInput($model, 'parent', ['value' => 0, 'class' => 'comment-parent-field']) ?>

    <?= Html::activeHiddenInput($model, 'post_id', ['value' => $post->id]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Submit'), ['class' => 'btn btn-primary']) ?>

    </div>
    <?php ActiveForm::end() ?>

</div>
