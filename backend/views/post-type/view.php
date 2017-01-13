<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model cms\models\PostType */

$this->title = Yii::t('cms', 'View Post Type: {name}', ['name' => $model->singular_name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Post Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-type-view">
    <p>
        <?= Html::a(
            Yii::t('cms', 'Update'),
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-flat btn-primary']
        ) ?>

        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-flat btn-danger',
            'data' => [
                'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'description:ntext',
            [
                'attribute' => 'icon',
                'value' => Html::tag('i', '', ['class' => $model->icon]),
                'format' => 'raw',
            ],
            'singular_name',
            'plural_name',
            'menu_builder:boolean',
            'permission',
        ],
    ]) ?>

</div>
<div class="taxonomy-view">
    <?php if ($taxonomies = $model->taxonomies): ?>
        <h3><?= Yii::t('cms', 'Taxonomies') ?></h3>

        <?php foreach ($taxonomies as $taxonomy): ?>
            <?= Html::a(
                $taxonomy->name,
                ['/taxonomy/view/', 'id' => $taxonomy->id],
                ['class' => 'btn btn-xs btn-warning btn-flat']
            ) ?>
        <?php endforeach ?>

    <?php endif ?>
</div>
