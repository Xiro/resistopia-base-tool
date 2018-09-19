<?php

namespace app\controllers;

use Yii;
use app\models\Ticker;
use app\models\search\TickerSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TickerController implements the CRUD actions for Ticker model.
 */
class TickerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ticker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TickerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['order' => SORT_ASC]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionActiveMessages()
    {
        $messages = Ticker::find()
            ->where(['active' => 1])
            ->orderBy('order ASC')
            ->asArray()
            ->all();
        $messages = array_column($messages, 'message');

        return json_encode($messages);
    }

    /**
     * (for ajax use) search and render a table body
     * @return string
     */
    public function actionSearch()
    {
        $searchModel = new TickerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Ticker model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ["model" => $model]);
    }

    /**
     * Creates a new Ticker model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticker();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        if($model->order === null) {
            $model->order = Ticker::find()->count() + 1;
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * Updates an existing Ticker model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ["model" => $model]);
    }

    /**
     * AJAX action
     * Update the order of all given items
     * @return string
     * @throws NotFoundHttpException some model cannot be found
     */
    public function actionUpdateOrder()
    {
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        $post = Yii::$app->request->post();

        foreach ($post["order"] as $modelData) {
            $model = $this->findModel($modelData["id"]);
            $model->order = $modelData["order"];
            $success = $model->save();
            if(!$success) {
                return json_encode(["status" => "error"]);
            }
        }
        return json_encode(["status" => "success"]);
    }

    /**
     * Deletes an existing Ticker model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionConfirmDelete($id)
    {
        $model = $this->findModel($id);

        return $this->render('confirm-delete', ["model" => $model]);
    }

    /**
     * Deletes an existing Ticker model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException|\Exception if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticker::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}