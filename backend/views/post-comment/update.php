<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use dosamigos\datetimepicker\DateTimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model cms\models\PostComment */

$this->title = Yii::t('cms', 'Update {postType} Comment {id}', [
    'postType' => $model->commentPost->postType->singular_name,
    'id' => $model->id,
]);
$this->params['breadcrumbs'][] = [
    'label' => $model->commentPost->postType->singular_name,
    'url' => ['index', 'posttype' => $model->commentPost->postType->id],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->commentPost->id,
    'url' => ['index', 'posttype' => $model->commentPost->postType->id, 'post' => $model->commentPost->id],
];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update Comment');
?>
<?php $form = ActiveForm::begin(['id' => 'post-comment-update-form']) ?>

<div class="post-comment-update row">
    <div class="col-md-8">
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
        ]) ?>
    </div>
    <div class="col-md-4 post-comment-update">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'post_id',
                    'value' => Html::a($model->commentPost->title, [
                        '/post/update',
                        'id' => $model->commentPost->id,
                    ]),
                    'format' => 'raw',
                ],
                'author:ntext',
                'email:email',
                'url:url',
                [
                    'attribute' => 'ip',
                    'value' => Html::a(
                        $model->ip,
                        'http://whois.arin.net/rest/ip/' . $model->ip,
                        ['target' => '_blank']
                    ),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'date',
                    'value' => Html::a(
                        date('M d, Y H:i:s', strtotime($model->date)) . ' <i class="fa fa-pencil"></i>',
                        '#', [
                            'data-toggle' => 'modal',
                            'id' => 'date-link',
                            'data-target' => '#modal-for-date',
                        ]
                    ),
                    'format' => 'raw',
                ],
                'agent',
                [
                    'attribute' => 'parent',
                    'value' => $model->parent
                        ? Html::a($model->parent, ['update', 'id' => $model->parent, ])
                        : '',
                    'format' => 'raw',
                ],
                'user_id',
            ],
        ]) ?>

        <?= Html::a(
            '<span class="glyphicon glyphicon-share-alt"></span> ' . Yii::t('cms', 'Reply'),
            ['reply', 'id' => $model->id],
            ['class' => 'btn btn-sm btn-flat btn-success']
        ) ?>

        <?= Html::a(
            '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('cms', 'Delete'),
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-wd-post btn-sm btn-flat btn-danger pull-right',
                'data' => ['confirm' => Yii::t('cms', 'Are you sure you want to delete this item?')],
            ]
        ) ?>

    </div>
</div>
<?php Modal::begin([
    'header' => '<i class="glyphicon glyphicon-time"></i> ' . Yii::t('cms', 'Change Comment Date') . '',
    'id' => 'modal-for-date',
]) ?>

<?= $form->field($model, 'date', ['template' => "{label}\n{input}"])->widget(DateTimePicker::className(), [
    'template' => '{reset}{button}{input}',
    'pickButtonIcon' => 'glyphicon glyphicon-time',
    'options' => [
        'value' => date('M d, Y H:i:s', strtotime($model->date)),
    ],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'M dd, yyyy hh:ii:ss',
        'todayBtn' => true,
    ],
]) ?>

<?php Modal::end() ?>

<?php ActiveForm::end(); ?>
<?php $this->registerJs('$("#modal-for-date").on("hidden.bs.modal", function () {
    $("#date-link").html($("#postcomment-date").val() + \' <i class="fa fa-pencil"></i>\');
});') ?>
