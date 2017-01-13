<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $model cms\models\Taxonomy */

$this->title = Yii::t('cms', 'Add New Taxonomy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Taxonomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
