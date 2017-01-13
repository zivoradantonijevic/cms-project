<?php
/**
 * Created by PhpStorm.
 * User: marica
 * Date: 9.11.16.
 * Time: 13.17
 */

/* @var $this yii\web\View */
/* @var $content string */

$title = isset( $this->params['subtitle']) ? $this->params['subtitle'] : $this->title;
?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>

    </div>
    <div class="box-body">
        <?= $content;?>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        Footer
    </div>
    <!-- /.box-footer-->
</div>
<?php $this->endContent() ?>
