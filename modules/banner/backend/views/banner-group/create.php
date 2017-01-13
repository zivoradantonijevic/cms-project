<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model modules\banner\models\BannerGroup */

$this->title = 'Create Banner Group';
$this->params['breadcrumbs'][] = ['label' => 'Banner Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
