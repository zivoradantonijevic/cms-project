<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cebe\gravatar\Gravatar;
use codezeen\yii2\adminlte\widgets\Menu;
use cms\models\Option;
use cms\models\PostType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<aside class="main-sidebar">
    <section class="sidebar">

        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <?= Gravatar::widget([
                        'email' => Yii::$app->user->identity->email,
                        'options' => ['alt' => 'Gravatar 45', 'class' => 'img-circle'],
                        'size' => 45,
                    ]) ?>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->username ?></p>
                    <?= Html::a(
                        '<i class="fa fa-circle text-success"></i>' . Yii::t('cms', 'Online'),
                        ['/user/profile']
                    ) ?>
                </div>
            </div>
        <?php endif ?>

        <?php
        $adminMenu[0] = [
            'label' => Yii::t('cms', 'MAIN NAVIGATION'),
            'options' => ['class' => 'header'],
            'template' => '{label}',
        ];
        $adminMenu[1] = [
            'label' => Yii::t('cms', 'Dashboard'),
            'icon' => 'fa fa-dashboard',
            'items' => [
                ['icon' => 'fa fa-circle-o', 'label' => Yii::t('cms', 'Home'), 'url' => ['/site/index']],
            ],
        ];
        $adminMenu = ArrayHelper::merge($adminMenu, PostType::getMenus(2));
        $adminMenu[10] = [
            'label' => Yii::t('cms', 'Media'),
            'icon' => 'fa fa-picture-o',
            'items' => [
                ['icon' => 'fa fa-circle-o', 'label' => Yii::t('cms', 'All Media'), 'url' => ['/media/index']],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Add New Media'),
                    'url' => ['/media/create'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Comments'),
                    'url' => ['/media-comment/index'],
                    'visible' => Yii::$app->user->can('editor'),
                ],
            ],
            'visible' => Yii::$app->user->can('author'),
        ];
        $adminMenu[20] = [
            'label' => Yii::t('cms', 'Appearance'),
            'icon' => 'fa fa-paint-brush',
            'items' => [
                ['icon' => 'fa fa-circle-o', 'label' => Yii::t('cms', 'Menus'), 'url' => ['/menu/index']],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Theme'),
                    'url' => ['/theme/index']
                ],
                ['icon' => 'fa fa-circle-o', 'label' => Yii::t('cms', 'Widgets'), 'url' => ['/widget/index']],
            ],
            'visible' => Yii::$app->user->can('administrator'),
        ];
        $adminMenu[30] = [
            'label' => Yii::t('cms', 'Modules'),
            'icon' => 'fa fa-laptop',
            'items' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'All Modules'),
                    'url' => ['/module/index'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Add New Module'),
                    'url' => ['/module/create'],
                ],
            ],
            'visible' => Yii::$app->user->can('administrator'),
        ];
        $adminMenu[40] = [
            'label' => Yii::t('cms', 'Post Types'),
            'icon' => 'fa fa-files-o',
            'items' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'All Post Types'),
                    'url' => ['/post-type/index'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Add New Post Type'),
                    'url' => ['/post-type/create'],
                ],
            ],
            'visible' => Yii::$app->user->can('administrator'),
        ];
        $adminMenu[50] = [
            'label' => Yii::t('cms', 'Taxonomies'),
            'icon' => 'fa fa-tags',
            'items' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'All Taxonomies'),
                    'url' => ['/taxonomy/index'],
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Add New Taxonomy'),
                    'url' => ['/taxonomy/create'],
                ],
            ],
            'visible' => Yii::$app->user->can('administrator'),
        ];
        $adminMenu[60] = [
            'label' => Yii::t('cms', 'Users'),
            'icon' => 'fa fa-user',
            'items' => [
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'All Users'),
                    'url' => ['/user/admin'],
                    'visible' => Yii::$app->user->can('administrator'),
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Add New User'),
                    'url' => ['/user/admin/create'],
                    'visible' => Yii::$app->user->can('administrator'),
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'My Profile'),
                    'url' => ['/user/admin/update-profile', 'id' => Yii::$app->user->id],
                    'visible' => Yii::$app->user->can('subscriber'),
                ],
                [
                    'icon' => 'fa fa-circle-o',
                    'label' => Yii::t('cms', 'Reset Password'),
                    'url' => ['/user/admin/update'],
                    'visible' => Yii::$app->user->can('subscriber'),
                ],
            ],
        ];


        $adminMenu = ArrayHelper::merge($adminMenu, Option::getMenus(70));

        if ($userAdminMenu = ArrayHelper::getValue(Yii::$app->params, 'adminMenu', [])) {
            $adminMenu = ArrayHelper::merge($adminMenu, $userAdminMenu);
        }

        ksort($adminMenu);
        echo Menu::widget(['items' => $adminMenu]);
        ?>

    </section>
</aside>
