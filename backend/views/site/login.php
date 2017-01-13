<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use codezeen\yii2\adminlte\widgets\Alert;
use cms\models\Option;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('cms', 'Sign In');
?>
<div class="login-box">
    <div class="login-logo">
        <h1>
            <a href="http://www.writesdown.com/">
                <img src="<?= Yii::getAlias('@web/img/logo.png') ?>" alt="WritesDown">
            </a>
        </h1>
    </div>

    <?= Alert::widget() ?>

    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('cms', 'Sign in to start your session') ?></p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span></div>{error}',
        ])->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>{error}',
        ])->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Sign In', [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'name' => 'signin-button',
                ]) ?>

            </div>
        </div>
        <?php ActiveForm::end() ?>

        <?= Html::a(Yii::t('cms', 'Reset Password'), ['request-password-reset']) ?><br/>

        <?= Option::get('allow_signup') ? Html::a(Yii::t('cms', 'Register a new membership'), ['signup']) : "" ?>

    </div>
    <br/>
    <?= Html::a(
        '<i class="fa fa-home"></i> ' . Yii::t(
            'cms', 'Back to {sitetitle}',
            ['sitetitle' => Option::get('sitetitle')]
        ),
        Yii::$app->urlManagerFront->createUrl(['/site/index']),
        ['class' => 'btn btn-block btn-success']
    ) ?>

</div>
