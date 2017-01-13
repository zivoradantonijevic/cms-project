<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel cms\models\search\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $postType cms\models\PostType */
/* @var $user integer */

$this->title = $postType->plural_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="form-inline grid-nav" role="form">
        <div class="form-group">
            <?= Html::dropDownList(
                'bulk-action',
                null,
                ArrayHelper::merge($searchModel->getPostStatuses(), ['delete' => 'Delete']),
                ['class' => 'bulk-action form-control', 'prompt' => Yii::t('cms', 'Bulk Action')]
            ) ?>

            <?= Html::button(Yii::t('cms', 'Apply'), ['class' => 'btn btn-flat btn-warning bulk-button']) ?>

            <?= Html::a(
                Yii::t('cms', 'Add New {postType}', ['postType' => $postType->singular_name]),
                ['create', 'type' => $postType->id, ],
                ['class' => 'btn btn-flat btn-primary']
            ) ?>

            <?= ButtonDropdown::widget([
                'label' => Html::tag('i', '', ['class' => 'fa fa-user']) . ' Author',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => 'My Posts',
                            'url' => ['index', 'type' => $postType->id, 'user' => Yii::$app->user->id],
                        ],
                        ['label' => 'All Posts', 'url' => ['index', 'type' => $postType->id]],
                    ],
                ],
                'split' => true,
                'encodeLabel' => false,
                'options' => ['class' => 'btn btn-flat btn-danger'],
            ]) ?>

            <?= Html::button(Html::tag('i', '', ['class' => 'fa fa-search']), [
                'class' => 'btn btn-flat btn-info',
                'data-toggle' => 'collapse',
                'data-target' => '#post-search',
            ]) ?>

        </div>
    </div>
    <?php Pjax::begin() ?>
    <?= $this->render('_search', ['model' => $searchModel, 'postType' => $postType, 'user' => $user]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'post-grid-view',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    /* @var $model \cms\models\search\Post */
                    if ($model->getPermission()) {
                        return ['value' => $model->id];
                    }

                    return ['disabled' => 'disabled'];
                },
            ],
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    /* @var $model \cms\models\search\Post */
                    return $model->postAuthor->username;
                },
            ],
            'title:ntext',
            'date',
            ['attribute' => 'status', 'filter' => $searchModel->getPostStatuses()],
            ['attribute' => 'comment_status', 'filter' => $searchModel->getCommentStatuses()],
            ['attribute' => 'featured', 'filter' => $searchModel->getBooleanStatuses(), 'class'=>'common\components\ToggleColumn'],
            ['attribute' => 'views_count', 'filter' => false],
          //  'comment_count',

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
                        /* @var $model \cms\models\search\Post */
                        if ($model->getPermission()) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                        }

                        return '';
                    },
                    'delete' => function ($url, $model) {
                        /* @var $model \cms\models\search\Post */
                        if ($model->getPermission()) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                        return '';
                    },
                ],
            ],
        ],
    ]) ?>

    <?php Pjax::end() ?>

</div>
<?php $this->registerJs('jQuery(".bulk-button").click(function(e){
    e.preventDefault();
    if(confirm("' . Yii::t("app", "Are you sure to do this?") . '")){
        var ids     = $("#post-grid-view").yiiGridView("getSelectedRows"); // returns an array of pkeys, and #grid is your grid element id
        var action  = $(this).parents(".form-group").find(".bulk-action").val();
        $.ajax({
            url: "' . Url::to(["bulk-action"]) . '",
            data: { ids: ids, action: action, _csrf: yii.getCsrfToken() },
            type:"POST",
            success: function(data){
                $.pjax.reload({container:"#post-grid-view"});
            }
        });
    }
});') ?>
