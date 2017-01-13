<?php
/**
 * Project: goalserve
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 8.11.16.
 */

use core\user\widgets\Connect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var core\user\models\LoginForm $model
 * @var core\user\Module $module
 */
?>
<div class="panel panel-default">

    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'action'=>Yii::$app->user->loginUrl,
            'id' => 'login-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnChange' => false,
        ]) ?>

        <?= $form->field(
            $model,
            'login',
            [
                'inputOptions' => [
                    'autofocus' => 'autofocus',
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'placeholder' => Yii::t('user', 'Username'),
                ]
            ]
        )->label(false) ?>

        <?= $form
            ->field(
                $model,
                'password',
                [
                    'inputOptions' => [
                        'class' => 'form-control',
                        'tabindex' => '2',
                        'placeholder' => Yii::t('user', 'Password')
                    ],

                ]
            )
            ->passwordInput()
            ->label(false) ?>

        <div class="row">
            <div class="checklabel checkbox">
                <div class="col-xs-8">
        <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>
            </div>
            </div>
            <div class="col-xs-4">
        <?= Html::submitButton(
            Yii::t('user', 'Sign in'),
            ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']
        ) ?>
            </div>
        </div>
        <?= Html::a(
            Yii::t('user', 'Forgot password?'),
            ['/user/recovery/request'],
            ['tabindex' => '5']
        ); ?>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
        </p>
        <?php ActiveForm::end(); ?>

    </div>
</div>



<?= Connect::widget([
    'baseAuthUrl' => ['/user/security/auth'],
]) ?>
