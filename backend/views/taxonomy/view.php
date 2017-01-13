<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model cms\models\Taxonomy */
/* @var $searchModel cms\models\Taxonomy */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $term cms\models\Term */

$this->title = Yii::t('cms', 'View Taxonomy: {name}', ['name' => $model->singular_name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Taxonomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-view">
    <?php Pjax::begin() ?>

    <div class="row">
        <div class="col-md-4">
            <?= $this->render('/term/_form', ['model' => $term, 'taxonomy' => $model]) ?>
        </div>
        <div class="col-md-8">
            <?= $this->render('/term/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'taxonomy' => $model,
            ]) ?>
        </div>
    </div>
    <?php Pjax::end() ?>

</div>
