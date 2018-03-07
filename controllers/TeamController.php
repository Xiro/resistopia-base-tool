<?php

namespace app\controllers;

use app\models\form\TeamForm;
use app\models\MissionStaff;
use app\models\MissionStatus;
use app\models\search\StaffSearch;
use Yii;
use app\models\Team;
use app\models\search\TeamSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamSearch();
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
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'models' => $dataProvider->getModels()
        ]);
    }

    /**
     * Displays a single Team model.
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
     * Displays a single Team model.
     * @param integer $id
     * @return mixed
     * @throws \Exception
     */
    public function actionPay($id)
    {
        $model = $this->findModel($id);

        $params = [];

        $staffIds = array_column($model->getStaff()->select("id")->asArray()->all(), "id");
        $staffIdsCondition = \Yii::$app->db->getQueryBuilder()->buildCondition(
            ['IN', 'staff_id', $staffIds],
            $params
        );
        $missionStatusCondition = \Yii::$app->db->getQueryBuilder()->buildCondition(
            ['m.mission_status_id' => MissionStatus::completedId()]
            , $params
        );

        $isUpdated = Yii::$app->db->createCommand(
            "UPDATE mission_staff ms " .
            "JOIN mission m ON ms.mission_id = m.id " .
            "SET paid = 'Yes' " .
            "WHERE $staffIdsCondition " .
            "AND $missionStatusCondition",
            $params
        )->execute();

        if ($isUpdated) {
            Yii::$app->session->setFlash("success", $model->name . " was paid");
        } else {
            Yii::$app->session->setFlash("error", var_export($isUpdated, true) . " Error paying " . $model->name);
        }
        return $this->redirect(['index']);
    }

    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TeamForm();

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
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = TeamForm::findOne($id);
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

    /**
     * loads search table body of the staff selection in the team form
     * @return string
     */
    public function actionSearchStaff()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere("team_id IS NULL");

        return $this->renderPartial("../staff/_staff-select-table-form-body", [
            "staffModels" => $dataProvider->getModels(),
            "modelName"   => "TeamForm",
            "exclude"     => ["team"],
        ]);
    }

    /**
     * add parameters to display the staff search in the team form
     * @param $viewParams
     */
    protected function addStaffSearchParams(&$viewParams)
    {
        $searchModel = new StaffSearch();
        $staffDataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $staffDataProvider->query->where("team_id IS NULL");
        $viewParams["staffSearch"] = $searchModel;
        $viewParams["staffDataProvider"] = $staffDataProvider;
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
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}