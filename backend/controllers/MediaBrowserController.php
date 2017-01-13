<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license
 */

namespace backend\controllers;

use common\components\Json;
use common\components\MediaUploadHandler;
use cms\models\Media;
use cms\models\Post;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class MediaBrowserController, controlling the actions for for Media model in Media Browser.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.3.0
 */
class MediaBrowserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'get-json', 'get-paging', 'editor-insert', 'field-insert'],
                        'allow' => true,
                        'roles' => ['author'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'editor-insert' => ['post'],
                    'field-insert' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays files browser for editor and field.
     *
     * @param int|null $post
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($post = null)
    {
        $this->layout = "blank";
        $model = new Media(['scenario' => 'upload']);

        if (isset($post) && !$post = $this->findPost($post)->id) {
            throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
        }

        return $this->render('index', [
            'post' => $post,
            'model' => $model,
        ]);
    }

    /**
     * Get JSON data from Media.
     *
     * @param int|null $id
     */
    public function actionGetJson($id = null)
    {
        $uploadHandler = new MediaUploadHandler(null, MediaUploadHandler::NOT_PRINT_RESPONSE);
        $uploadHandler->get($id);
    }


    /**
     * Insert file to editor.
     *
     * @return string
     */
    public function actionEditorInsert()
    {
        $result = '';

        foreach (Yii::$app->request->post('Media') as $media) {
            $type = ArrayHelper::getValue($media, 'type');
            if ($type === 'image') {
                $result .= $this->getMediaImage($media);
            } elseif ($type === 'video') {
                $result .= $this->getMediaVideo($media);
            } elseif ($type === 'audio') {
                $result .= $this->getMediaAudio($media);
            } else {
                $result .= $this->getMediaFile($media);
            }
        }

        return $result;
    }

    /**
     * Insert URL of media to input field.
     *
     * @return string
     */
    public function actionFieldInsert()
    {
        $files = [];

        foreach (Yii::$app->request->post('Media') as $media) {
            $mediaUploadHandler = new MediaUploadHandler(null, false);
            $file = $mediaUploadHandler->get(
                ArrayHelper::getValue($media, 'id'),
                $mediaUploadHandler::NOT_PRINT_RESPONSE
            );
            $files[] = ArrayHelper::getValue($file, 'file');
        }

        return Json::encode($files);
    }

    /**
     * Finds the Media model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Media the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Media::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPost($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * Generate image tag for media.
     *
     * @param array $media
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMediaImage($media)
    {
        $result = '';
        $model = $this->findModel(ArrayHelper::getValue($media, 'id'));
        $meta = $model->getMeta('metadata');
        $image = $model->getThumbnail(ArrayHelper::getValue($media, 'version'), [
                'data-id' => $model->id,
                'class' => 'media-image media-' . $model->id . ' ' . ArrayHelper::getValue($media, 'align', 'none'),
            ]) . "\n";

        if ($model->excerpt) {
            $result .= Html::beginTag('div', [
                    'class' => ArrayHelper::getValue($media, 'align', 'none') . ' media-caption',
                    'style' => 'width: ' . $meta['versions'][$media['version']]['width'] . 'px',
                ]) . "\n";
        }

        if ($linkValue = ArrayHelper::getValue($media, 'link_value')) {
            $result .= Html::beginTag('a', [
                    'href' => $linkValue,
                    'class' => ArrayHelper::getValue($media, 'align', 'none'),
                ]) . "\n";
        }

        $result .= $image;

        if ($linkValue = ArrayHelper::getValue($media, 'link_value')) {
            $result .= Html::endTag('a') . "\n";
        }

        if ($model->excerpt) {
            $result .= Html::tag('div', $model->excerpt, ['class' => 'media-caption-text']) . "\n";
            $result .= Html::endTag('div') . "\n";
        }

        return $result;
    }

    /**
     * Generate video tag for editor and use HTML5.
     *
     * @param array $media
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMediaVideo($media)
    {
        $model = $this->findModel(ArrayHelper::getValue($media, 'id'));
        $meta = $model->getMeta('metadata');
        $result = Html::beginTag('video', [
                'controls' => true,
                'class' => 'media-video media-' . $model->id,
            ]) . "\n";
        $result .= Html::tag('source', '', [
                'src' => $model->getUploadUrl() . ArrayHelper::getValue($meta, 'versions.full.url'),
                'type' => $model->mime_type,
            ]) . "\n";
        $result .= 'Your browser does not support the <code>video</code> element.' . "\n";
        $result .= Html::endTag('video') . "\n";

        return $result;
    }

    /**
     * Generate audio tag for editor and use HTML5.
     *
     * @param array $media
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMediaAudio($media)
    {
        $model = $this->findModel(ArrayHelper::getValue($media, 'id'));
        $meta = $model->getMeta('metadata');
        $result = Html::beginTag('audio', [
                'controls' => true,
                'class' => 'media-audio media-' . $model->id,
            ]) . "\n";
        $result .= Html::tag('source', '', [
                'src' => $model->getUploadUrl() . ArrayHelper::getValue($meta, 'versions.full.url'),
                'type' => $model->mime_type,
            ]) . "\n";
        $result .= 'Your browser does not support the <code>video</code> element.' . "\n";
        $result .= Html::endTag('audio') . "\n";

        return $result;
    }

    /**
     * Generate link to media file for editor.
     *
     * @param array $media
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMediaFile($media)
    {
        $model = $this->findModel(ArrayHelper::getValue($media, 'id'));

        return Html::a(
            $model->title,
            ArrayHelper::getValue($media, 'link_value'),
            ['class' => 'media-file media-' . $model->id]
        );
    }
}
