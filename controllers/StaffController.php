<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\forms\AccessKeyForm;
use Yii;
use app\models\Staff;
use app\models\forms\StaffForm;
use app\models\search\StaffSearch;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
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
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * (for ajax use) search and render a table form body
     * @param string $teamId
     * @return string
     */
    public function actionSearchTeamForm($teamId)
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere([
            'or',
            ['!=', 'team_id', $teamId],
            ['team_id' => null]
        ]);

        return $this->renderPartial('_table-form-body', [
            'dataProvider' => $dataProvider,
            "modelName"    => "TeamForm",
            'exclude'      => ['team']
        ]);
    }

    /**
     * (for ajax use) search and render a table form body
     * @param string $missionId
     * @return string
     */
    public function actionSearchMissionForm($missionId = null)
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($missionId) {
            /** @var ActiveQuery $query */
            $query = $dataProvider->query;
            $query->joinWith('missions')
                ->andWhere([
                    'or',
                    ['!=', 'mission.id', $missionId],
                    ['mission.id' => null]
                ]);
        }

        return $this->renderPartial('_table-form-body', [
            'dataProvider' => $dataProvider,
            "modelName"    => "MissionForm",
            'exclude'      => ['callsign']
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ["model" => $model]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaffForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = StaffForm::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ["model" => $model]);
    }

    /**
     * Update the AccessKey of a staff member
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGrantRights($id)
    {
        $model = $this->findModel($id);

        $accessKey = AccessKeyForm::findOne($model->access_key_id);
        if ($accessKey === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $post = Yii::$app->request->post();
        $accessKey->load($post);
        if ($post && $accessKey->save()) {
            return $this->goBack(['index']);
        }

        return $this->render('grant-rights', [
            'model'     => $model,
            'accessKey' => $accessKey,
        ]);
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
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException|\Exception if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}