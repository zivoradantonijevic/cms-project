<?php

namespace modules\banner\backend\controllers;

use modules\banner\models\Banner;
use modules\banner\models\search\Banner as BannerSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'bulk-action'],
                        'allow' => true,
                        'roles' => ['author'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Banner models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banner model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();

        // Load Old Image
        $oldImage = $model->image;
        // Load imagePath from Module Params
        $imagePath = Yii::getAlias('@public/uploads/banner/');

        // Create uploadImage Instance
        $image = $model->uploadImage($imagePath,'image');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->image = $oldImage;
            } else {

                // if is there an old image, delete it
                if ($oldImage) {
                    $model->deleteImage($oldImage);
                }

                // upload new image
                $model->image = $image->name;
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Load Old Image
        $oldImage = $model->image;
        // Load imagePath from Module Params
        $imagePath = Yii::getAlias('@public/uploads/banner/');

        // Create uploadImage Instance
        $image = $model->uploadImage($imagePath, 'image');
        
        if ($model->load(Yii::$app->request->post()) ) {
            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->image = $oldImage;
            } else {

                // if is there an old image, delete it
                if ($oldImage) {
                    $model->deleteImage($oldImage);
                }

                // upload new image
                $model->image = $image->name;
            }
            if( $model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
