<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $available [] */
/* @var $active [] */
/* @var $spaces [] */

$index = 0;
$sizeofSpaces = sizeof($spaces);
$divideSpaces = round($sizeofSpaces / 2);
?>
<?php foreach ($spaces as $space): ?>
    <?php if ($index == 0 || $index == $divideSpaces): ?>
        <div class="col-sm-12 col-md-6">
    <?php endif ?>

    <div id="widget-space-<?= ArrayHelper::getValue($space, 'location') ?>"
         class="widget-space box collapsed-box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?= ArrayHelper::getValue($space, 'title') ?></h3>

            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="box-body">

            <?php if ($spaceDescription = ArrayHelper::getValue($space, 'description')): ?>
                <p><?= $spaceDescription ?></p>
            <?php endif ?>

            <div class="widget-order">

                <?php if (isset($active[$space['location']])): ?>
                    <?php foreach ($active[$space['location']] as $widget): ?>
                        <?= $this->render('_active', [
                            'available' => $available,
                            'active' => $widget,
                        ]) ?>
                    <?php endforeach ?>
                <?php endif ?>

            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['/site/forbidden']),
            'options' => [
                'class' => 'widget-order-form box-footer',
                'data' => ['url' => Url::to(['ajax-save-order'])],
            ],
        ]) ?>

        <?= Html::hiddenInput('Widget[order]', null, ['class' => 'widget-order-field']) ?>

        <?= Html::submitButton(Yii::t('cms', 'Save Order'), ['class' => 'btn btn-flat btn-success btn-block']) ?>

        <?php $form::end() ?>

    </div>

    <?php if ($index == $divideSpaces - 1 || $index == $sizeofSpaces - 1): ?>
        </div>
    <?php endif ?>

    <?php $index++ ?>

<?php endforeach ?>
