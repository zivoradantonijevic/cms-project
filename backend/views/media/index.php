<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel cms\models\search\Media */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Media');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-index">
    <div class="form-inline grid-nav" role="form">
        <div class="form-group">
            <?= Html::dropDownList('bulk-action', null, ['delete' => 'Delete Permanently'], [
                'prompt' => Yii::t('cms', 'Bulk Action'),
                'class' => 'bulk-action form-control',
            ]) ?>

            <?= Html::button(Yii::t('cms', 'Apply'), [
                'class' => 'btn btn-flat btn-warning bulk-button',
                'data-type' => 'DELETE',
            ]) ?>

            <?= Html::a(Yii::t('cms', 'Add New Media'), ['create'], ['class' => 'btn btn-flat btn-primary']) ?>

            <?= Html::button(Html::tag('i', '', ['class' => 'fa fa-search']), [
                'class' => 'btn btn-flat btn-info',
                "data-toggle" => "collapse",
                "data-target" => "#media-search",
            ]) ?>

        </div>
    </div>
    <?php Pjax::begin() ?>
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'media-grid-view',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    if (!Yii::$app->user->can('editor') && $model->author !== Yii::$app->user->id) {
                        return ['disabled' => 'disabled'];
                    }

                    return ['value' => $model->id];
                },
            ],
            [
                'attribute' => Yii::t('cms', 'Preview'),
                'format' => 'raw',
                'value' => function ($model) {
                    /* @var $model cms\models\Media */
                    $metadata = $model->getMeta('metadata');
                    $iconUrl = ArrayHelper::getValue($metadata, 'icon_url');

                    if (preg_match('/^image\//', $model->mime_type)) {
                        return Html::a(Html::img($model->getUploadUrl() . $iconUrl), [
                            'update',
                            'id' => $model->id,
                        ], ['class' => 'media-mime-icon']);
                    }

                    return Html::a(Html::img(Url::base(true) . '/' . $iconUrl), [
                        'update',
                        'id' => $model->id,
                    ], ['class' => 'media-mime-icon']);
                },
            ],
            [
                'label' => Yii::t('cms', 'File Name'),
                'format' => 'html',
                'value' => function ($model) {
                    /* @var $model cms\models\Media */
                    $metadata = $model->getMeta('metadata');

                    return Html::a(ArrayHelper::getValue($metadata, 'filename', '#'), ['update', 'id' => $model->id]);
                },
            ],
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    return $model->mediaAuthor->username;
                },
            ],
            'date:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $model->url, [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if (!Yii::$app->user->can('editor') && $model->author !== Yii::$app->user->id) {
                            return '';
                        }

                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if (!Yii::$app->user->can('editor') && $model->author !== Yii::$app->user->id) {
                            return '';
                        }

                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

    <?php Pjax::end() ?>

</div>
<?php $this->registerJs('jQuery(document).on("click", ".bulk-button", function(e){
    e.preventDefault();
    if(confirm("' . Yii::t('cms', 'Are you sure?') . '")){
        var ids     = $("#media-grid-view").yiiGridView("getSelectedRows");
        var action  = $(this).closest(".form-group").find(".bulk-action").val();
        $.ajax({
            url: "' . Url::to(['bulk-action']) . '",
            data: { ids: ids, action: action, _csrf: yii.getCsrfToken() },
            type: "POST",
            success: function(data){
                $.pjax.reload({container:"#media-grid-view"});
            }
        });
    }
});'); ?>
