<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\Slider */

$this->title = 'Update Slider: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="slider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
