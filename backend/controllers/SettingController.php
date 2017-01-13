<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace backend\controllers;

use cms\models\Option;
use cms\models\search\Option as OptionSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SettingController implements the CRUD actions for Option model.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class SettingController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                    [
                        'actions' => ['group'],
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Option models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays single Option model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Option model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Option();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Option model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Option model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Render option page for specific group of option.
     * It will use group file if exist.
     *
     * @param string $id
     * @return mixed
     */
    public function actionGroup($id)
    {
        $model = $this->findModelByGroup($id);

        if ($options = Yii::$app->request->post('Option')) {
            foreach ($options as $optionName => $option) {
                Option::up($optionName, $option['value']);
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Settings successfully saved.'));

            return $this->redirect(['group', 'id' => $id]);
        }

        if (is_file($this->getViewPath() . '/' . strtolower($id) . '.php')) {
            return $this->render(strtolower($id), [
                'model' => (object)$model,
                'group' => $id,
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Option model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Option the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Option::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

    /**
     * Finds the Option models based on their group.
     * If the models are not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     * @return Option the loaded model
     * @throws NotFoundHttpException if the models cannot be found
     */
    protected function findModelByGroup($id)
    {
        if ($model = Option::find()->where(['group' => $id])->indexBy('name')->all()) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }
}
