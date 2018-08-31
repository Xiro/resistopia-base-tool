<?php

namespace app\controllers;

use Yii;
use app\models\Changelog;
use app\models\search\ChangelogSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChangelogController implements the CRUD actions for Changelog model.
 */
class ChangelogController extends Controller
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
     * Lists all Changelog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChangelogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('created DESC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * (for ajax use) search and render a table body
     * @return string
     */
    public function actionSearch()
    {
        $searchModel = new ChangelogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!$searchModel->created) {
            $dataProvider->query->orderBy('created DESC');
        }

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Changelog model.
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
     * Finds the Changelog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Changelog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Changelog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}