<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\banner\models\BannerGroup */

$this->title = 'Update Banner Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banner Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="banner-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
