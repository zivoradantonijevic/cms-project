<?php

use modules\banner\models\BannerGroup;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\banner\models\search\Banner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'label'=>'Group',
                'attribute' => 'group_id',
                'value' => function ($model) {
                    return $model->group ? $model->group->name : null;
                },
                'filter'=>ArrayHelper::map(BannerGroup::find()->asArray()->all(), 'id', 'name')
            ],
            'author',
            //'code:ntext',
            // 'image',
            // 'url:url',
            'start_time:datetime',
            'end_time:datetime',
            'impressions',
            'clicks',
            // 'sortorder',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>' {update} {delete}'],
        ],
    ]); ?>
</div>
