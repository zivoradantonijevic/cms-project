<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $model cms\models\Option */

$this->title = Yii::t('cms', 'Update Setting: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Setting'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="option-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
