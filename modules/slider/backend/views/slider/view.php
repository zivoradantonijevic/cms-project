<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\Slider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view">
    
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
    $url = $model->getImageUrl();
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
            'sortorder',
            'is_published',
            'title_en',
            'title_tr',
            'subtitle_en',
            'subtitle_tr',
        ],
    ]) ?>

</div>
