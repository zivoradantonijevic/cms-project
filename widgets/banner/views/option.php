<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use modules\banner\models\BannerGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $widget cms\models\Widget */

?>
<?php $config = $widget->getConfig() ?>
<?= Html::hiddenInput('Widget[config][class]', $config['class']) ?>

<div class="form-group">
    <?= Html::label('Title', 'title-' . $widget->id, ['class' => 'form-label']) ?>

    <?= Html::textInput(
        'Widget[config][title]',
        $config['title'],
        ['class' => 'form-control input-sm']
    ) ?>

</div>
<div class="form-group">
    <?= Html::label('Group', 'banner-' . $widget->id, ['class' => 'form-label']) ?>

    <?= Html::dropDownList('Widget[config][group]', $config['group'],
        ArrayHelper::map(BannerGroup::find()->asArray()->all(), 'id', 'name'),
        ['class' => 'form-control input-sm']) ?>

</div>

<div class="form-group">
    <?= Html::label('Count', 'count-' . $widget->id, ['class' => 'form-label']) ?>

    <?= Html::textInput(
        'Widget[config][count]',
        $config['count'],
        ['class' => 'form-control input-sm']
    ) ?>

</div>