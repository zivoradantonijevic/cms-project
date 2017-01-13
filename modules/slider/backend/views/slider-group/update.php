<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\SliderGroup */

$this->title = 'Update Slider Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Slider Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="slider-group-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
