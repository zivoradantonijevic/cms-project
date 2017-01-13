<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $model cms\models\Taxonomy */

$this->title = Yii::t('cms', 'Update Taxonomy: {name}', ['name' => $model->singular_name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Taxonomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->singular_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="taxonomy-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
