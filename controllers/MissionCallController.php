<?php

namespace app\controllers;

use app\models\form\MissionCallForm;
use Yii;
use app\models\MissionCall;
use app\models\search\MissionCallSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MissionCallController implements the CRUD actions for MissionCall model.
 */
class MissionCallController extends Controller
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
                        'allow' => true,
//                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MissionCall models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MissionCallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MissionCall model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ["model" => $model]);
    }

    /**
     * Creates a new MissionCall model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MissionCallForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * Updates an existing MissionCall model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = MissionCallForm::findOne($id);
        if(!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ["model" => $model]);
    }

    /**
     * Deletes an existing EyeColor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionConfirmDelete($id)
    {
        $model = $this->findModel($id);

        return $this->render('confirm-delete', ["model" => $model]);
    }

    /**
     * Deletes an existing MissionCall model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MissionCall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MissionCall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MissionCall::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}