<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace frontend\controllers;

use btool\core\models\League;
use cms\models\Option;
use cms\models\Post;
use cms\models\PostComment;
use frontend\models\ContactForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class SiteController
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Render home page of the site.
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionIndex()
    {
        /* @var $post \cms\models\Post */

        $query = Post::find()
            ->from(['t' => Post::tableName()])
            ->andWhere(['status' => 'publish'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->orderBy(['t.date' => SORT_DESC]);

        if (Option::get('show_on_front') == 'page' && $frontPage = Option::get('front_page')) {
            $render = '/post/view';
            $comment = new PostComment();
            $query = $query->andWhere(['id' => $frontPage]);
            if ($post = $query->one()) {
                if (is_file($this->view->theme->basePath . '/post/view-' . $post->postType->slug . '.php')) {
                    $render = '/post/view-' . $post->postType->slug;
                }

                return $this->render($render, [
                    'post' => $post,
                    'comment' => $comment,
                ]);
            }
            throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
        } else {
            if (Option::get('front_post_type') !== 'all') {
                $query->innerJoinWith(['postType'])->andWhere(['name' => Option::get('front_post_type')]);
            }
            $countQuery = clone $query;
            $pages = new Pagination([
                'totalCount' => $countQuery->count(),
                'pageSize' => Option::get('posts_per_page'),
            ]);
            $query->offset($pages->offset)->limit($pages->limit);
            if ($posts = $query->all()) {
                return $this->render('index', [
                    'posts' => $posts,
                    'pages' => isset($pages) ? $pages : null,
                ]);
            }

            throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Option::get('admin_email'))) {
                Yii::$app->session->setFlash(
                    'success',
                    'Thank you for contacting us. We will respond to you as soon as possible.'
                );
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Search post by title and content
     *
     * @param string $s Keyword to search posts.
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSearch($s)
    {
        $query = Post::find()
            ->orWhere(['like', 'title', $s])
            ->orWhere(['like', 'content', $s])
            ->andWhere(['status' => 'publish'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->orderBy(['date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => Option::get('posts_per_page'),
        ]);
        $query->offset($pages->offset)->limit($pages->limit);
        $posts = $query->all();

        if ($posts) {
            return $this->render('/site/search', [
                'posts' => $posts,
                'pages' => $pages,
                's' => $s,
            ]);
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionForbidden()
    {
        throw new ForbiddenHttpException(Yii::t('cms', 'You are not allowed to perform this action.'));
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionNotFound()
    {
        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    public function actionTest()
    {
        $league = League::findOne(127528);
        _p( $league->title);
    }
}
