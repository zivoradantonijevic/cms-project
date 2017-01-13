<?php

use modules\slider\models\SliderGroup;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\slider\models\search\Slider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Slider', ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter'=>ArrayHelper::map(SliderGroup::find()->asArray()->all(), 'id', 'name')
            ],
            'author',
            [
                'class' => 'common\components\ToggleColumn',
                'attribute' => 'is_published',
                'action' => 'togglePublished',
                'options' => ['style' => 'width:60px'],
            ],
            //'code:ntext',
            // 'image',
            // 'url:url',
            // 'sortorder',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>' {update} {delete}'],
        ],
    ]); ?>
</div>
