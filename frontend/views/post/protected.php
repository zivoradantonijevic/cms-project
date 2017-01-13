<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use cms\models\Option;
use cms\models\Taxonomy;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post cms\models\Post */
/* @var $comment cms\models\PostComment */
/* @var $category cms\models\Term */

$this->title = Html::encode($post->title . ' - ' . Option::get('sitetitle'));
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($post->postType->singular_name),
    'url' => ['/post/index', 'id' => $post->postType->id],
];
$category = $post->getTerms()
    ->innerJoinWith([
        'taxonomy' => function ($query) {
            /* @var $query \yii\db\ActiveQuery */
            $query->from(['taxonomy' => Taxonomy::tableName()]);
        },
    ])
    ->andWhere(['taxonomy.name' => 'category'])
    ->one();

if ($category) {
    $this->params['breadcrumbs'][] = ['label' => Html::encode($category->name), 'url' => $category->url];
}

$this->params['breadcrumbs'][] = Html::encode($post->title);
?>

<div class="single post-protected">
    <article class="hentry">
        <header class="entry-header page-header">
            <h1 class="entry-title"><?= Html::encode($post->title) ?></h1>

        </header>
        <div class="entry-content">
            <?php $form = ActiveForm::begin() ?>

            <p>
                <?= Yii::t(
                    'cms',
                    '{title} is protected, please submit the right password to view the {type}.',
                    [
                        'title' => Html::encode($post->title),
                        'type' => Html::encode($post->postType->singular_name),
                    ]
                ) ?>

            </p>
            <div class="form-group field-post-password required">
                <?= Html::label(
                    Yii::t('cms', 'Password'),
                    'post-password',
                    ['class' => 'control-label']
                ) ?>

                <?= Html::passwordInput('password', null, [
                    'class' => 'form-control',
                    'id' => 'post-password',
                ]) ?>

            </div>

            <div class="form-group">
                <?= Html::submitButton(
                    Yii::t('cms', 'Submit Password'),
                    ['class' => 'btn btn-flat btn-primary']
                ) ?>

            </div>

            <?php ActiveForm::end() ?>
        </div>
    </article>
</div>
