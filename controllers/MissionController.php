<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\forms\MissionForm;
use app\models\Mission;
use app\models\MissionStatus;
use app\models\Operation;
use app\models\search\MissionSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

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
            'index-lead',
            'templates',
            'archive',
            'control',
            'planned',
            'called',
            'active'
        ];
        if (in_array($action->id, $referToActions)) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all Mission models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->renderIndexView('Missions', false);
    }

    /**
     * Lists all Mission models.
     * @return mixed
     */
    public function actionTemplates()
    {
        return $this->renderIndexView('Mission Templates', ['template']);
    }

    /**
     * Lists all Mission models.
     * @return mixed
     */
    public function actionArchive()
    {
        return $this->renderIndexView('Mission Archive', ['completed', 'failed']);
    }

    /**
     * @param $title
     * @param $statusNames
     * @return string
     */
    protected function renderIndexView($title, $statusNames)
    {
        $this->actionCheckPublishMission();
        $searchModel = new MissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($statusNames) {
            $statusNames = is_array($statusNames) ? $statusNames : [$statusNames];
            $statusIds = $this->getStatusIds();
            $statusIds = array_intersect_key($statusIds, array_flip($statusNames));
            $dataProvider->query->andWhere([
                'mission_status_id' => $statusIds
            ]);
            $searchUrl = Url::to([
                'mission/search',
                'statusIds' => implode('|', $statusIds)
            ]);
        } else {
            $searchUrl = Url::to(['mission/search']);
        }

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'searchUrl'    => $searchUrl,
            'title'        => $title,
        ]);
    }

    /**
     * (for ajax use) search and render a table body
     * @param integer $statusIds
     * @return string
     */
    public function actionSearch($statusIds = null)
    {
        $this->actionCheckPublishMission();
        $searchModel = new MissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($statusIds) {
            $statusIds = explode('|', $statusIds);
            $dataProvider->query->andWhere([
                'mission_status_id' => $statusIds
            ]);
        }

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionControl()
    {
        return $this->renderTables([
            'Active'  => ['active'],
//            'Ready'   => ['ready'],
//            'Open'    => ['openLeadercall', 'openCrewcall'],
            'Planing' => ['planing'],
            'Back'    => ['back'],
        ], 'Mission Control', 'control');
    }

    /**
     * @return string
     */
    public function actionPlanned()
    {
        return $this->renderTables([
            'Planing' => ['planing'],
        ], 'Planned Missions');
    }

//    /**
//     * @return string
//     */
//    public function actionCalled()
//    {
//        return $this->renderTables([
//            'Crewcall'   => ['openCrewcall'],
//            'Leadercall' => ['openLeadercall'],
//        ], 'Called Missions');
//    }

    /**
     * @return string
     */
    public function actionActive()
    {
        $statusIds = $this->getStatusIds();
        $activeOperations = Operation::find()
            ->joinWith("missions")
            ->where(['mission.mission_status_id' => $statusIds['active']])
            ->all();

        $tableQueries = [];
        $tableQueries[] = Mission::find()
            ->where(['mission.mission_status_id' => $statusIds['active']])
            ->andWhere(['is', 'operation_id', null]);

        /** @var Operation $operation */
        foreach ($activeOperations as $operation) {
            $tableQueries["Operation " . $operation->name] = Mission::find()
                ->where(['mission.mission_status_id' => $statusIds['active']])
                ->andWhere(['operation_id' => $operation->id]);
        }
        return $this->render('tables', [
            'title'  => 'Active Missions',
            'tables' => $tableQueries
        ]);
    }

    /**
     * @param $tables
     * @param null $title
     * @param string $view
     * @return string
     */
    protected function renderTables($tables, $title = null, $view = 'tables')
    {
        $this->actionCheckPublishMission();
        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }

        $statusIds = $this->getStatusIds();
        $tableQueries = [];
        foreach ($tables as $tableHeading => $statusNames) {
            $filterStatusIds = array_intersect_key($statusIds, array_flip($statusNames));
            $tableQueries[$tableHeading] = Mission::find()
                ->where(['mission_status_id' => $filterStatusIds]);
        }

        return $this->render($view, [
            'title'  => $title,
            'tables' => $tableQueries
        ]);
    }

    public function actionScreen()
    {
        $this->layout = Yii::$app->request->isAjax ? false : 'blank';

        $tables = ['planing', 'active'];

        $statusIds = $this->getStatusIds();
        $tableQueries = [];
        foreach ($tables as $statusName) {
            $tableQueries[] = Mission::find()->where([
                'mission_status_id' => $statusIds[$statusName]
            ]);
        }

        return $this->render('screen', [
            'tableQueries' => $tableQueries
        ]);
    }

//    public function actionGate($id = null)
//    {
//        $statusIds = $this->getStatusIds();
//        $model = null;
//        if ($id) {
//            $model = MissionGateForm::findOne([
//                'mission_lead_sid'  => $id,
//                'mission_status_id' => [
//                    $statusIds['ready'],
//                    $statusIds['active'],
//                    $statusIds['back'],
//                ],
//            ]);
//        }
//        if (!$model) {
//            $model = new MissionGateForm();
//            $model->mission_lead_sid = $id;
//        }
//        if ($model->load(Yii::$app->request->post())) {
//            if ($model->save()) {
//                Yii::$app->session->addFlash('success', 'Mission saved');
//            } else {
//                Yii::$app->session->addFlash('error', 'Failed to save mission');
//            }
//        }
//        return $this->render('gate', [
//            'model' => $model
//        ]);
//    }

    /**
     * Displays a single Mission model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ["model" => $model]);
    }

//    /**
//     * @return string
//     */
//    public function actionIndexLead()
//    {
//        $leadMissions = Mission::find()
//            ->where(['mission_lead_sid' => AccessRule::activeStaff()->sid])
//            ->all();
//        return $this->render('index-lead', [
//            'models' => $leadMissions
//        ]);
//    }

    /**
     * Creates a new Mission model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id mission ID of template to load from
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new MissionForm();
        $model->created_by_sid = AccessRule::activeStaff()->sid;

        if ($id) {
            $templateData = $this->findModel($id)->getAttributes();
            $model->load(['MissionForm' => $templateData]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack(['control']);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * Updates an existing Mission model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        return $this->processUpdate($id, 'update');
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateCrew($id)
    {
        $model = $this->findModel($id);
        if ($model->mission_lead_sid != AccessRule::activeStaff()->sid) {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
        return $this->processUpdate($id, 'update-crew');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDebrief($id)
    {
        return $this->processUpdate($id, 'debrief');
    }

    /**
     * @param $id
     * @param $view
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    protected function processUpdate($id, $view)
    {
        $model = MissionForm::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack(['control']);
        }

        return $this->render($view, ["model" => $model]);
    }

    /**
     * @param $missionId
     * @param $statusId
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSwitchStatus($missionId, $statusId)
    {
        $model = $this->findModel($missionId);
        $model->mission_status_id = $statusId;
        if ($model->save()) {
            Yii::$app->session->addFlash('success', 'Mission Status changed');
        } else {
            Yii::$app->session->addFlash('error', 'Error changing Mission Status');
        }
        return $this->goBack();

    }

    /**
     * Check for missions to automatically publish
     */
    public function actionCheckPublishMission()
    {
        $statusIds = $this->getStatusIds();
        /** @var Mission[] $missions */
        $missions = Mission::find()
            ->where(['mission_status_id' => $statusIds['OT']])
            ->andWhere(['<=', 'time_publish', date('Y-m-d H:i:s')])
            ->all();
        foreach ($missions as $mission) {
            $mission->mission_status_id = $statusIds['planing'];
            $mission->save();
        }
    }

    public function actionIsReceivingData()
    {
        $receivingTime = strtotime("now +10 seconds");
        $statusIds = $this->getStatusIds();
        /** @var Mission[] $missions */
        $missionCount = Mission::find()
            ->where(['mission_status_id' => $statusIds['OT']])
            ->andWhere(['<=', 'time_publish', date('Y-m-d H:i:s', $receivingTime)])
            ->count();
        return $missionCount > 0 ? 1 : 0;
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
     * Deletes an existing Mission model.
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

    /**
     * @return array
     */
    protected function getStatusIds()
    {
        return MissionStatus::getStatusIds();
    }

}