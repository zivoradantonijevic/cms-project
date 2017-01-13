<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use cms\models\Option;
use frontend\widgets\comment\MediaComment;
use yii\helpers\Html;

/* @var $comment cms\models\MediaComment */
/* @var $media cms\models\Media */

?>
<div id="comment-view">
    <?php if ($media->comment_count): ?>
        <h2 class="comment-title">
            <?= Yii::t('cms', '{comment_count} {comment_word} on {title}', [
                'comment_count' => $media->comment_count,
                'comment_word' => $media->comment_count > 1 ? 'Replies' : 'Reply',
                'title' => $media->title,
            ]) ?>

        </h2>

        <?= MediaComment::widget(['model' => $media, 'id' => 'comments']) ?>

    <?php endif ?>

    <?php if ($media->comment_status == 'open'): ?>
        <?php $dateInterval = date_diff(new DateTime($media->date), new DateTime('now')) ?>
        <?php if (Option::get('comment_registration') && Yii::$app->user->isGuest): ?>
            <h3>
                <?= Yii::t('cms', 'You must login to leave a reply, ') ?>

                <?= Html::a(Yii::t('cms', 'Login'), Yii::$app->urlManagerBack->createUrl(['site/login'])); ?>

            </h3>
        <?php elseif (Option::get('close_comments_for_old_posts')
            && $dateInterval->d >= Option::get('close_comments_days_old')
        ): ?>
            <h3><?= Yii::t('cms', 'Comments are closed') ?></h3>;
        <?php else: ?>
            <?= $this->render('_form', [
                'model' => $comment,
                'media' => $media,
            ]) ?>
        <?php endif ?>
    <?php elseif ($media->comment_count && $media->comment_status === 'close'): ?>
        <h3><?= Yii::t('cms', 'Comments are closed') ?></h3>;
    <?php endif ?>

</div>
