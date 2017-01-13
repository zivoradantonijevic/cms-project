<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

/* @var $this yii\web\View */
/* @var $model cms\models\PostType */
/* @var $taxonomy cms\models\Taxonomy */
/* @var $taxonomies [] */

$this->title = Yii::t('cms', 'Add New Post Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Post Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 post-type-create">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $this->render('_post-type-taxonomy', [
            'model' => $model,
            'taxonomy' => $taxonomy,
            'taxonomies' => $taxonomies,
        ]) ?>
    </div>
</div>
