<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 8.9.16.
 */
use backend\widgets\MediaModal;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model cms\models\Post */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Thumbnail</h3>

        <div class="box-tools pull-right">
            <a href="#" data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></a>
        </div>
    </div>
    <div class="box-body">
        <img id="thumbnail"/>
        <?= MediaModal::widget([
            'post' => $model->isNewRecord ? null : $model->id,
            'editor' => false,
            'multiple' => false,
            'buttonOptions' => [
                'class' => ['btn btn-sm btn-default btn-flat'],
            ],
            'callback' => [
                'name' => 'perica',
                'value' => new JsExpression('function(response){
                response = $.parseJSON(response);
                console.log(response);
                console.log(response[0]);
                console.log(response[0].versions);
                insertThumbnail(response[0].versions.full.url);
            }')
            ]
        ]) ?>
        <?= $form->field($model, 'thumbnail', ['template' => '{input}{error}'])->textInput() ?>
    </div>
</div>
<script>
    function insertThumbnail(url) {
        $("#post-thumbnail").val(url);
        $("#thumbnail").attr("src", "<?= Url::base() . '/../uploads/';?>" + url);
        $("#thumbnail").show();
    }
    function setThumbnail() {
        var value = $("#post-thumbnail").val();
        var $img = $("#thumbnail");
        $img.attr("src", "<?= Url::base() . '/../uploads/';?>" + value);
        if (value != '') {
            $img.show();
        }
        else {
            $img.hide();
        }
    }
</script>
<script rel="inline-ready">


    $("#post-thumbnail").change(function () {
        setThumbnail();
    });
    setThumbnail();
</script>