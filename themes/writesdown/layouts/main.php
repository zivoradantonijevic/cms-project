<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use codezeen\yii2\adminlte\widgets\Alert;
use frontend\components\FrontendHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $content string */
$isHome = FrontendHelper::isHomepage();
?>
<?php $this->beginContent('@app/views/layouts/blank.php') ?>
<div class="wrapper">
    <?= $this->render('main-header') ?>
    <?= $this->render('sidebar-left') ?>
    <div class="content-wrapper">
        <?php if( !$isHome || ArrayHelper::getValue($this->params, 'breadcrumbs', [])): ?>
            <section class="content-header">
                <h1><?= $this->title ?></h1>
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Html::a(
                            '<i class="fa fa-dashboard"></i> ' . Yii::t('cms', 'Home'),
                            Yii::$app->homeUrl
                        ),
                    ],
                    'encodeLabels' => false,
                    'links' => ArrayHelper::getValue($this->params, 'breadcrumbs', []),
                ]) ?>
            </section>
        <?php endif ?>

        <section class="content clearfix">
            <?= Alert::widget() ?>
            <?= $content ?>
        </section>
    </div>
    <?= $this->render('main-footer') ?>
</div>
<?php $this->endContent() ?>
