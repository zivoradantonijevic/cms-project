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
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $posts cms\models\Post[] */
/* @var $tags cms\models\Term[] */
/* @var $image cms\models\Media */
/* @var $pages yii\data\Pagination */

$this->title = Html::encode(Yii::t('cms', 'All Posts By {user}', ['user' => $user->display_name])
    . ' - ' . Option::get('sitetitle'));
$this->params['breadcrumbs'][] = Html::encode(Yii::t('cms', 'All Posts by {user}',
    ['user' => $user->display_name]));
?>
<div class="archive user-view">
    <header id="archive-header" class="archive-header">
        <h1><?= Html::encode(Yii::t('cms', 'All Posts By {user}', ['user' => $user->display_name])) ?></h1>

    </header>

    <?php if ($posts): ?>
        <?php foreach ($posts as $post) : ?>
            <article class="hentry">
                <header class="entry-header">
                    <h2 class="entry-title"><?= Html::a(Html::encode($post->title), $post->url) ?></h2>

                    <?php $updated = new \DateTime($post->modified, new DateTimeZone(Yii::$app->timeZone)) ?>
                    <div class="entry-meta">
                        <span class="entry-date">
                            <a rel="bookmark" href="<?= $post->url ?>">
                                <time datetime="<?= $updated->format('c') ?>" class="entry-date">
                                    <?= Yii::$app->formatter->asDate($post->date) ?>
                                </time>
                            </a>
                        </span>
                        <span class="byline">
                            <span class="author vcard">
                                <a rel="author" href="<?= $post->postAuthor->url ?>"
                                   class="url fn"><?= $post->postAuthor->name ?>
                                </a>
                            </span>
                        </span>
                        <span class="comments-link">
                            <a title="<?= Yii::t(                                 'cms', 'Comment on {post}',
                                ['post' => $post->title]
                            ) ?>" href="<?= $post->url ?>#respond"><?= Yii::t('cms', 'Leave a comment') ?></a>
                        </span>
                    </div>
                </header>
                <div class="media">
                    <?php $image = $post->getMedia()->where(['like', 'mime_type', 'image/'])->one() ?>

                    <?php if ($image): ?>
                        <?= Html::a($image->getThumbnail(
                            'thumbnail',
                            ['class' => 'post-thumbnail']),
                            $post->url,
                            ['class' => 'media-left entry-thumbnail']
                        ) ?>
                    <?php endif ?>

                    <div class="media-body">
                        <p class="entry-summary">
                            <?= $post->excerpt ?>...

                        </p>

                        <footer class="footer-meta">
                            <?php $tags = $post->getTerms()
                                ->innerJoinWith([
                                    'taxonomy' => function ($query) {
                                        /** @var $query \yii\db\ActiveQuery */
                                        return $query->from(['taxonomy' => Taxonomy::tableName()]);
                                    },
                                ])
                                ->where(['taxonomy.name' => 'tag'])
                                ->all() ?>

                            <?php if ($tags): ?>
                                <h3>
                                    <?php foreach ($tags as $tag): ?>
                                        <?= Html::a($tag->name, $tag->url, ['class' => 'badge']) . "\n" ?>
                                    <?php endforeach ?>
                                </h3>
                            <?php endif ?>

                        </footer>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
        <nav id="archive-pagination">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'options' => ['class' => 'pagination'],
            ]);
            ?>
        </nav>
    <?php endif ?>

</div>
