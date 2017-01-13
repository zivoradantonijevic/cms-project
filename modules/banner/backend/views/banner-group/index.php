<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\banner\models\search\BannerGroup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banner Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-group-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['style' => 'width:60px']
            ],
            'name',
            'width',
            'height',
            

            ['class' => 'yii\grid\ActionColumn',
                'template'=>' {update} {delete}'],
        ],
    ]); ?>
</div>
