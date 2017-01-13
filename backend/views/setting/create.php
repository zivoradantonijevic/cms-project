<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $model cms\models\Option */

$this->title = Yii::t('cms', 'Add New Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
