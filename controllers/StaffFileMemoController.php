<?php

namespace app\controllers;

use app\components\Access;
use app\components\AccessRule;
use Yii;
use app\models\StaffFileMemo;
use app\models\search\StaffFileMemoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffFileMemoController implements the CRUD actions for StaffFileMemo model.
 */
class StaffFileMemoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'      => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class
                ],
                'rules'      => [
                    [
                        'allow' => true,
                        'roles' => ['§'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $referToActions = [
            'index',
        ];
        if (in_array($action->id, $referToActions)) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all StaffFileMemo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffFileMemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * (for ajax use) search and render a table body
     * @return string
     */
    public function actionSearch()
    {
        $searchModel = new StaffFileMemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single StaffFileMemo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->access_right_id && !Access::to($model->accessRight->key)) {
            return $this->render('../site/error', [
                'name'    => '#403 Forbidden',
                'message' => 'You are not allowed to access this entry.'
            ]);
        }
        return $this->render('view', ["model" => $model]);
    }

    /**
     * Creates a new StaffFileMemo model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new StaffFileMemo();
        $model->rpn = $id;
        $model->author_rpn = AccessRule::activeStaff()->rpn;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack(['index']);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * Updates an existing StaffFileMemo model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->access_right_id && !Access::to($model->accessRight->key)) {
            return $this->render('../site/error', [
                'name'    => '#403 Forbidden',
                'message' => 'You are not allowed to access this entry.'
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack(['index']);
        }

        return $this->render('update', ["model" => $model]);
    }

    /**
     * Deletes an existing EyeColor model.
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
     * Deletes an existing StaffFileMemo model.
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
     * Finds the StaffFileMemo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffFileMemo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffFileMemo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}