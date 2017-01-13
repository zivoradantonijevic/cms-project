<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use backend\assets\WidgetAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $active [] */
/* @var $available [] */
/* @var $spaces [] */

$this->title = Yii::t('cms', 'Widgets');
$this->params['breadcrumbs'][] = $this->title;
WidgetAsset::register($this);
?>
<div class="row">
    <div class="col-sm-push-6 col-md-push-5 col-sm-6 col-md-7">
        <div class="row">
            <?= $this->render('_space', [
                'active' => $active,
                'available' => $available,
                'spaces' => $spaces,
            ]) ?>
        </div>
    </div>
    <div class="col-sm-pull-6 col-md-pull-7 col-sm-6 col-md-5">
        <h4><?= Yii::t('cms', 'Available Widgets') ?></h4>

        <p class="description">
            <?= Yii::t('cms', 'To activate widget, click on + (plus), choose the location and click activate') ?>
        </p>
        <div class="row">
            <?= $this->render('_available', [
                'available' => $available,
                'spaces' => $spaces,
            ]) ?>
        </div>
        <div class="form-group">
            <?= Html::a(
                Yii::t('cms', 'Add New Widget'),
                ['create'],
                ['class' => 'btn btn-default btn-block']
            ) ?>

        </div>
    </div>
</div>
