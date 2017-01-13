<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model modules\slider\models\SliderGroup */

$this->title = 'Create Slider Group';
$this->params['breadcrumbs'][] = ['label' => 'Slider Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-group-create">
    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
