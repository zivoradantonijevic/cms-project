<?php

/*
 * This file is part of the Sport project.
 *
 * (c) Zivorad Antonijevic <http://github.com/zantonijevic/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View              $this
 * @var core\user\models\User $user
 * @var core\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="register-box">
            <div class="register-box-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>
                <?= $form->errorSummary($model);?>

                <?= $form->field($model, 'email') ?>
              
                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>
                <div class="row">
                    <div class="col-xs-8">
                        </div>
                    <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <br/>
                <p class="text-center">
                    <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                </p>
            </div>
        </div>
</div>
