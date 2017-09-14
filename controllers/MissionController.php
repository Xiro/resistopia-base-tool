<?php

namespace app\controllers;

use app\models\form\MissionForm;
use app\models\MissionCall;
use app\models\MissionStatus;
use app\models\Operation;
use app\models\search\StaffSearch;
use app\models\StaffStatus;
use Yii;
use app\models\Mission;
use app\models\search\MissionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MissionController implements the CRUD actions for Mission model.
 */
class MissionController extends Controller
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
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search'       => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch()
    {
        $searchModel = new MissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial("_mission-table-body", [
            "missionModels" => $dataProvider->getModels()
        ]);
    }

    public function actionControl()
    {
        $activeOperations = Operation::find()
            ->joinWith("missions")
            ->where(["mission.mission_status_id" => MissionStatus::activeId()])
            ->groupBy("operation.id")
            ->all();

        return $this->render("control", [
            "operations" => $activeOperations
        ]);
    }

    /**
     * Displays a single Mission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ["model" => $model]);
    }

    /**
     * Creates a new Mission model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $viewParams = [
            "model" => $model,
        ];
        $this->addStaffSearchParams($viewParams);
        return $this->render('create', $viewParams);
    }

    /**
     * Creates a new Mission model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return mixed
     */
    public function actionCreateFromCall($id)
    {
        $missionCall = MissionCall::findOne($id);
        if(!$missionCall) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new MissionForm();
        $model->setAttributes($missionCall->getAttributes());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $missionCall->delete();
            return $this->redirect(['index']);
        }

        $viewParams = [
            "model" => $model,
        ];
        $this->addStaffSearchParams($viewParams);
        return $this->render('create', $viewParams);
    }

    public function actionSearchStaff()
    {
        $searchModel = $this->createStaffSearchModelForSelect();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial("../staff/_staff-select-table-form-body", [
            "staffModels" => $dataProvider->getModels(),
            "modelName"   => "MissionForm",
        ]);
    }

    /**
     * Updates an existing Mission model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = MissionForm::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $viewParams = [
            "model" => $model,
        ];
        $this->addStaffSearchParams($viewParams);
        return $this->render('update', $viewParams);
    }

    protected function addStaffSearchParams(&$viewParams)
    {
        $searchModel = $this->createStaffSearchModelForSelect();
        $staffDataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $viewParams["staffSearch"] = $searchModel;
        $viewParams["staffDataProvider"] = $staffDataProvider;
    }

    protected function createStaffSearchModelForSelect()
    {
        $searchModel = new StaffSearch();
        $searchModel->staff_status_id = StaffStatus::findOne(["name" => StaffStatus::STATUS_ALIVE])->id;
        $searchModel->is_blocked = "No";
        return $searchModel;
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
     * Deletes an existing Mission model.
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
     * Finds the Mission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}