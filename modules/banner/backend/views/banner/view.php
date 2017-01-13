<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\banner\models\Banner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
    $url = $model->getImageUrl('image');
    if ($url) {
        $model->image = Html::img($url);
    }
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
           ['label'=>'Group',
           'value'=>$model->group ? $model->group->name : null],
            ['label'=>'Author',
                'value'=>$model->owner ? $model->owner->name : null],
            'code:ntext',
            'image:html',
            'url:url',
            'start_time:datetime',
            'end_time:datetime',
            'sortorder',
        ],
    ]) ?>

</div>
