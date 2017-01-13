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
/* @var $metadata [] */
/* @var $model cms\models\Media */

$this->title = Yii::t('cms', 'Update Media');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => $model->getUrl()];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<?php $form = ActiveForm::begin(['id' => 'media-update-form']) ?>

<div class="media-update">
    <div class="row">
        <div class="col-md-8">
            <?= $this->render('_form', [
                'model' => $model,
                'form' => $form,
                'metadata' => $metadata,
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'author',
                        'value' => $model->mediaAuthor->username,
                    ],
                    [
                        'attribute' => 'post_id',
                        'format' => 'raw',
                        'value' => $model->post_id
                            ? Html::a($model->mediaPost->title, ['/post/update', 'id' => $model->mediaPost->id])
                            : Yii::t('cms', 'Unattached'),
                    ],
                    [
                        'attribute' => 'date',
                        'value' => Html::a(
                            date('M d, Y H:i:s', strtotime($model->date))
                            . ' <i class="fa fa-pencil"></i>', '#', [
                                'data-toggle' => 'modal',
                                'id' => 'date-link',
                                'data-target' => '#modal-for-date',
                            ]
                        ),
                        'format' => 'raw',
                    ],
                    'modified',
                    'mime_type',
                    [
                        'attribute' => 'comment_count',
                        'format' => 'raw',
                        'value' => Html::a($model->comment_count, ['/media-comment/index', 'media' => $model->id]),
                    ],
                ],
            ]) ?>

            <?= !$model->isNewRecord
                ? Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-wd-post btn-sm btn-flat btn-danger',
                    'data' => ['confirm' => Yii::t('cms', 'Are you sure you want to delete this item?')],
                ])
                : '' ?>

        </div>
    </div>
</div>
<?php Modal::begin([
    'header' => '<i class="glyphicon glyphicon-time"></i> ' . Yii::t('cms', 'Change Media Date') . '',
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

<?php ActiveForm::end() ?>

<?php $this->registerJs('$("#modal-for-date").on("hidden.bs.modal", function () {'
    . '$("#date-link").html($("#media-date").val() + \' <i class="fa fa-pencil"></i>\');'
    . '});') ?>
