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
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel cms\models\search\PostType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Post Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-type-index">
    <div class="form-inline grid-nav" role="form">
        <div class="form-group">
            <?= Html::dropDownList('bulk-action', null, ['deleted' => Yii::t('cms', 'Delete Permanently')], [
                'class' => 'bulk-action form-control',
                'prompt' => Yii::t('cms', 'Bulk Action'),
            ]) ?>

            <?= Html::button(Yii::t('cms', 'Apply'), ['class' => 'btn btn-flat btn-warning bulk-button']) ?>

            <?= Html::a(
                Yii::t('cms', 'Add New Post Type'),
                ['create'],
                ['class' => 'btn btn-flat btn-primary']
            ) ?>

            <?= Html::button(Html::tag('i', '', ['class' => 'fa fa-search']), [
                'class' => 'btn btn-flat btn-info',
                'data-toggle' => 'collapse',
                'data-target' => '#post-type-search',
            ]) ?>

        </div>
    </div>
    <?php Pjax::begin() ?>
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'post-type-grid-view',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'name',
            'slug',
            'description:ntext',
            [
                'attribute' => 'icon',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('i', '', ['class' => $model->icon]);
                },
                'filter' => false,
            ],
            'singular_name',
            'plural_name',
            [
                'attribute' => 'menu_builder',
                'format' => 'boolean',
                'filter' => $searchModel->getMenuBuilders(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>

    <?php Pjax::end() ?>

</div>
<?php $this->registerJs('jQuery(".bulk-button").click(function(e){
    e.preventDefault();
    if(confirm("' . Yii::t('cms', 'Are you sure?') . '")){
    var ids     = $("#post-type-grid-view").yiiGridView("getSelectedRows");
    var action  = $(this).parents(".form-group").find(".bulk-action").val();
    $.ajax({
        url: "' . Url::to(["bulk-action"]) . '",
        data: { ids: ids, action: action, _csrf: yii.getCsrfToken() },
        type:"POST",
        success: function(data){
            $.pjax.reload({container:"#post-type-grid-view"});
        }
    });
    }
});') ?>
