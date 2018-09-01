<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\MissionStatus;
use mate\yii\widgets\SelectData;
use Yii;
use app\models\Mission;
use app\models\forms\MissionForm;
use app\models\search\MissionSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
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
            'Back'    => ['back'],
            'Active'  => ['active'],
            'Ready'   => ['ready'],
            'Open'    => ['openLeadercall', 'openCrewcall'],
            'Planing' => ['planing'],
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

    /**
     * @return string
     */
    public function actionCalled()
    {
        return $this->renderTables([
            'Crewcall'   => ['openCrewcall'],
            'Leadercall' => ['openLeadercall'],
        ], 'Called Missions');
    }

    /**
     * @return string
     */
    public function actionActive()
    {
        return $this->renderTables([
            'Back'   => ['back'],
            'Active' => ['active'],
            'Ready'  => ['ready'],
        ], 'Active Missions');
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

    /**
     * Creates a new Mission model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $id mission ID of template to load from
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new MissionForm();
        $model->created_by_rpn = AccessRule::activeStaff()->rpn;

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
            ->where(['mission_status_id' => $statusIds['planing']])
            ->andWhere(['<=','time_publish', date('Y-m-d H:i:s')])
            ->all();
        foreach ($missions as $mission) {
            $mission->mission_status_id = $statusIds['openLeadercall'];
            $mission->save();
        }
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
        return SelectData::fromModel(MissionStatus::class, 'name', 'id');
    }

}