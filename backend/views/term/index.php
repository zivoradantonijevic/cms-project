<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel cms\models\search\Term */
/* @var $taxonomy cms\models\Taxonomy */
?>
<div class="term-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'term-grid-view',
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'name',
            'slug',
            'description:ntext',
            'count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                            '/taxonomy/update-term',
                            'id' => $model->taxonomy->id,
                            'term' => $model->id,
                        ], [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', [
                            '/taxonomy/delete-term',
                            'id' => $model->taxonomy->id,
                            'term' => $model->id,
                        ], [
                            'title' => Yii::t('cms', 'Delete'),
                            'data-confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

    <div class="form-inline grid-nav" role="form">
        <div class="form-group">
            <?= Html::dropDownList('bulk-action', null, ['deleted' => Yii::t('cms', 'Delete Permanently')], [
                'prompt' => Yii::t('cms', 'Bulk Action'),
                'class' => 'bulk-action form-control',
            ]) ?>

            <?= Html::button(Yii::t('cms', 'Apply'), ['class' => 'btn btn-flat btn-warning bulk-button']) ?>

            <?= Html::button(Html::tag('i', '', ['class' => 'fa fa-search']), [
                'class' => 'btn btn-flat btn-info',
                'data-toggle' => 'collapse',
                'data-target' => '#term-search',
            ]) ?>

        </div>
    </div>
    <?= $this->render('_search', ['model' => $searchModel, 'taxonomy' => $taxonomy]) ?>
</div>
<?php $this->registerJs('jQuery(".bulk-button").click(function(e){
    e.preventDefault();
    if(confirm("' . Yii::t('cms', 'Are you sure?') . '")){
        var ids     = $("#term-grid-view").yiiGridView("getSelectedRows"); // returns an array of pkeys, and #grid is your grid element id
        var action  = $(this).parents(".form-group").find(".bulk-action").val();
        $.ajax({
            url: "' . Url::to(["/term/bulk-action"]) . '",
            data: { ids: ids, action: action, _csrf: yii.getCsrfToken() },
            type:"POST",
            success: function(data){
                $.pjax.reload({container:"#term-grid-view"});
            }
        });
    }
});') ?>
