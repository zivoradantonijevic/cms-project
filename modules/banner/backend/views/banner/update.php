<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\banner\models\Banner */

$this->title = 'Update Banner: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
