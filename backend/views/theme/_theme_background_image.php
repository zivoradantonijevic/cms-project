<?php
/**
 * Created by PhpStorm.
 * User: Marica Antonijevic
 * Date: 10/10/2016
 * Time: 11:19 AM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model object */
/* @var $group string */


?>

<div class="form-group"  style="margin-top:20px">
    <?= Html::label(Yii::t('cms', 'Upload your background image'), 'option-theme_background_image', ['class' => 'col-sm-2 control-label']) ?>

    <div class="col-sm-7" style="padding-top: 7px;">
        <?php if ($model->theme_background_image->value):
            $image = Html::img('/uploads/theme/' . $model->theme_background_image->value, ['style' => "max-width:200px"]);
            ?>
            <?= Html::a($image, '/uploads/theme/' . $model->theme_background_image->value, ['target' => '_blank']); ?>
        <?php endif; ?>
        <?= Html::fileInput('theme_background_image_file', $model->theme_background_image->value, [
            'class' => 'form-control',
            'id' => 'option-theme_background_image',
        ]); ?>
        <?= Html::hiddenInput('Option[theme_background_image][value]', $model->theme_background_image->value, [
            'class' => 'form-control',
            'id' => 'option-theme_background_image',
        ]) ?>

        <p class="description">
            Background image that will be shown on all pages except langing page
        </p>
    </div>

</div>