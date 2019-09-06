<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\AccessCategory;
use Yii;
use app\models\AccessRight;
use app\models\forms\AccessRightForm;
use app\models\search\AccessRightSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccessRightController implements the CRUD actions for AccessRight model.
 */
class AccessRightController extends Controller
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
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AccessRight models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccessRightSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['order' => SORT_ASC]
        ]);
        $dataProvider->setPagination(false);

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
        $searchModel = new AccessRightSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_table-body', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single AccessRight model.
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
     * Creates a new AccessRight model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccessRightForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->post('submit') == "continue") {
                $model = new AccessRightForm();
            } else {
                return $this->redirect(['index']);
            }
        }

        if($model->order === null) {
            $model->order = AccessRight::find()->count() + 1;
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * This is for quickly creating CRUD access rights
     * @param $controller
     * @param null $categoryName
     * @return \yii\web\Response
     */
    public function actionCreateCrud($controller, $categoryName = null)
    {
        $controllerParts = explode("-", $controller);
        foreach ($controllerParts as $key => $controllerPart) {
            $controllerParts[$key] = ucfirst($controllerPart);
        }
        $controllerName = implode(' ', $controllerParts);

        $categoryName = $categoryName ? $categoryName : $controllerName;
        $category = new AccessCategory();
        $category->name = $categoryName;
        $category->order = AccessCategory::find()->count() + 1;
        $category->save();

        $crudNames = ['view', 'create', 'update', 'delete'];
        $rightOrder = AccessRight::find()->count();
        foreach ($crudNames as $crudName) {
            $rightOrder++;
            $bit = new AccessRight();
            $bit->key = $controller . '/' . $crudName;
            $bit->name = ucfirst($crudName) . ' ' . ucfirst($controllerName);
            $bit->order = $rightOrder;
            $bit->access_category_id = $category->id;
            $bit->save();
        }
        Yii::$app->cache->flush();
        Yii::$app->session->addFlash('success', 'CRUD rights created for ' . $categoryName);
        return $this->redirect(['site/index']);

    }

    /**
     * Updates an existing AccessRight model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = AccessRightForm::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

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
     * Deletes an existing AccessRight model.
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
     * Deletes an existing AccessRight model.
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
     * Finds the AccessRight model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccessRight the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccessRight::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}