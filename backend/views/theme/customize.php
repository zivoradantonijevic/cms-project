<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 10.10.16.
 */

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */

$this->title = Yii::t('cms', 'Theme Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="options-form nav-tabs-custom">
    <?php $form = ActiveForm::begin(['id' => 'option-media-form', 'options' => ['class' => 'form-horizontal','enctype'=>'multipart/form-data']]) ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Site Title',
                'content' => $this->render('_theme_title', ['model' => $model]),
            ],
            [
                'label' => 'Site logo',
                'content' => $this->render('_theme_logo', ['model' => $model]),
            ],
            [
                'label' => 'Site background image',
                'content' => $this->render('_theme_background_image', ['model' => $model]),
            ],
            [
                'label' => 'Cookie notice',
                'content' => $this->render('_theme_cookie_notice', ['model' => $model]),
            ],
            [
                'label' => 'Splash page',
                'content' => $this->render('_theme_splash_page', ['model' => $model]),
            ],
            [
                'label' => 'Social icons',
                'content' => $this->render('_theme_social_icons', ['model' => $model]),
            ],
            [
                'label' => 'Copyright',
                'content' => $this->render('_theme_copyright', ['model' => $model]),
            ],
            [
                'label' => 'Site headline',
                'content' => $this->render('_theme_site_headline', ['model' => $model]),
            ],
        ]
    ]); ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-flat btn-success']) ?>

        </div>
    </div>
    <?php ActiveForm::end() ?>

</div>
