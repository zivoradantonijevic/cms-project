<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use cms\models\Option;
use frontend\assets\CommentAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $media cms\models\Media */
/* @var $metadata [] */
/* @var $comment cms\models\MediaComment */

$this->title = Html::encode($media->title . ' - ' . Option::get('sitetitle'));

if ($media->mediaPost) {
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($media->mediaPost->title),
        'url' => $media->mediaPost->url,
    ];
}

$this->params['breadcrumbs'][] = Html::encode($media->title);
CommentAsset::register($this);
?>
<div class="single media-view">
    <article class="hentry">
        <header class="entry-header page-header">
            <h1 class="entry-title"><?= Html::encode($media->title) ?></h1>

            <?php $updated = new \DateTime($media->modified, new DateTimeZone(Yii::$app->timeZone)) ?>
            <div class="entry-meta">
                <span class="entry-date">
                    <span aria-hidden="true" class="glyphicon glyphicon-time"></span>
                    <a rel="bookmark" href="<?= $media->url ?>">
                        <time datetime="<?= $updated->format('c') ?>" class="entry-date">
                            <?= Yii::$app->formatter->asDate($media->date) ?>
                        </time>
                    </a>
                </span>
                <span class="byline">
                    <span class="author vcard">
                        <span aria-hidden="true" class="glyphicon glyphicon-user"></span>
                        <a rel="author" href="<?= $media->mediaAuthor->url ?>" class="url fn">
                            <?= $media->mediaAuthor->display_name ?>
                        </a>
                    </span>
                </span>
                <span class="comments-link">
                    <span aria-hidden="true" class="glyphicon glyphicon-comment"></span>
                    <a title="<?= Yii::t(
                        'cms', 'Comment on {mediaTitle}',
                        ['mediaTitle' => $media->title]
                    ) ?>" href="<?= $media->url ?>#respond"><?= Yii::t('cms', 'Leave a comment') ?></a>
                </span>
            </div>
        </header>

        <div class="entry-content">
            <?= $media->content ?>

            <?= Html::a($media->title, $media->uploadUrl . $metadata['versions']['full']['url']) ?>

            <?= $media->mediaPost
                ? Html::tag('h3', Html::a('<span aria-hidden="true" class="glyphicon glyphicon-menu-left"></span>'
                    . Yii::t('cms', 'Back to ')
                    . $media->mediaPost->title, $media->mediaPost->url))
                : '' ?>

        </div>
    </article>
    <?= $this->render('/media-comment/comments', ['media' => $media, 'comment' => $comment]) ?>
</div>
