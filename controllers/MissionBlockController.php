<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\Staff;
use Yii;
use app\models\MissionBlock;
use app\models\search\MissionBlockSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MissionBlockController implements the CRUD actions for MissionBlock model.
 */
class MissionBlockController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class
                ],
                'rules' => [
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

    /**
     * Lists all MissionBlock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MissionBlockSearch();
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
        $searchModel = new MissionBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single MissionBlock model.
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
     * Creates a new MissionBlock model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        if (!($staff = Staff::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new MissionBlock();
        $model->blocked_staff_member_rpn = $staff->rpn;
        $model->blocked_by_rpn = AccessRule::activeStaff()->rpn;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', $staff->nameWithRpn . ' is now blocked for missions');
            return $this->redirect(['staff/index']);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * unblock a staff member
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionLift($id)
    {
        if (!($staff = Staff::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        foreach ($staff->activeMissionBlocks as $model) {
            $model->unblock_time = date('Y.m.d H:i', time() - 1);
            if($model->save()) {
                Yii::$app->session->addFlash('success', 'Mission block lifted from ' . $model->blockedStaffMember->nameWithRpn);
            } else {
                Yii::$app->session->addFlash('error', 'Error lifting the mission block');
            }
        }
        return $this->goBack(['staff/index']);
    }

    /**
     * Updates an existing MissionBlock model.
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
     * Deletes an existing MissionBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException|\Exception if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['staff/index']);
    }

    /**
     * Finds the MissionBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MissionBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MissionBlock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}