<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use cebe\gravatar\Gravatar;
use yii\helpers\Html;

/* @var $postCount int */
/* @var $commentCount int */
/* @var $userCount int */
/* @var $users common\models\User[] */
/* @var $posts cms\models\Post[] */
/* @var $comments cms\models\PostComment[] */

$this->title = Yii::t('cms', 'Dashboard');

?>
<div class="site-index">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon info-box-icon"><i class="fa fa-github"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Github</span>
                    <span>
                        <a aria-label="Follow @writesdown on GitHub" href="https://github.com/writesdown"
                           class="github-button">@writesdown</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-files-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('cms', 'Posts') ?></span>
                    <span><?= $postCount ?></span>
                </div>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('cms', 'Comments') ?></span>
                    <span><?= $commentCount ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('cms', 'Members') ?></span>
                    <span><?= $userCount ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('cms', 'Latest Posts') ?></h3>
                    <div class="box-tools pull-right">
                        <span class="label label-danger">
                            <?= Yii::t('cms', '{postCount} Posts', ['postCount' => $postCount]) ?>

                        </span>
                        <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?= Yii::t('cms', 'Author') ?></th>
                            <th><?= Yii::t('cms', 'Content') ?></th>
                            <th><?= Yii::t('cms', 'Published') ?></th>
                            <th><?= Yii::t('cms', 'Comments') ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?= $post->postAuthor->name ?></td>
                                <td><?= substr(strip_tags($post->excerpt), 0, 180) . '...' ?></td>
                                <td><?= date('M d, Y H:i:s', strtotime($post->date)) ?></td>
                                <td><?= $post->comment_count ?></td>
                                <td>
                                    <?= Html::a(
                                        '<span class="glyphicon glyphicon-eye-open"></span>',
                                        $post->url,
                                        ['title' => Yii::t('cms', 'View Post')]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('cms', 'Latest Members') ?></h3>
                    <div class="box-tools pull-right">
                        <span class="label label-warning">
                            <?= Yii::t('cms', '{userCount} Members', ['userCount' => $userCount]) ?>

                        </span>
                        <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">

                        <?php foreach ($users as $user): ?>
                            <li>
                                <?= Gravatar::widget([
                                    'email' => $user->email,
                                    'options' => ['alt' => $user->username],
                                    'size' => 128,
                                ]) ?>

                                <?= Html::a($user->name, $user->url, ['class' => 'users-list-name']) ?>

                                <?= Html::tag(
                                    'span',
                                    Yii::$app->formatter->asDate($user->created_at),
                                    ['class' => 'users-list-date']
                                ) ?>

                            </li>
                        <?php endforeach ?>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('cms', 'Latest Comments') ?></h3>
                    <div class="box-tools pull-right">
                        <span class="label label-success">
                            <?= Yii::t(                                 'cms',
                                '{commentCount} Comments',
                                ['commentCount' => $commentCount]
                            ) ?>

                        </span>
                        <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?= Yii::t('cms', 'Author') ?></th>
                            <th><?= Yii::t('cms', 'Comments') ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?= $comment->author ?></td>
                                <td><?= substr(strip_tags($comment->content), 0, 180) . '...' ?></td>
                                <td>
                                    <?= Html::a(
                                        '<span class="glyphicon glyphicon-eye-open"></span>',
                                        $comment->commentPost->url . '#comment-' . $comment->id,
                                        ['title' => Yii::t('cms', 'View Comment')]
                                    ) ?>

                                </td>
                            </tr>
                        <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
