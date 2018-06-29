<?php

namespace app\controllers;

use app\models\AccessRight;
use app\models\AccessCategory;
use mate\yii\components\SelectData;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
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
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $crud = [
//            'Missions' => 'mission',
        ];
        $crudNames = ['view', 'create', 'update', 'delete'];
        foreach ($crud as $categoryName => $controller) {
            $category = new AccessCategory();
            $category->name = $categoryName;
            $category->order = AccessCategory::find()->count() + 1;
            $category->save();

            $bitOrder = AccessRight::find()->count();
            foreach ($crudNames as $crudName) {
                $bitOrder++;
                $bit = new AccessRight();
                $bit->key = $controller . '/' . $crudName;
                $bit->name = ucfirst($crudName) . ' ' . ucfirst($controller);
                $bit->order = $bitOrder;
                $bit->access_category_id = $category->id;
                $bit->save();
            }
        }
        return $this->render('index');
    }

    public function actionClearCache()
    {
        /** @var SelectData $selectData */
        $selectData = Yii::$app->selectData;
        $selectData->clear();

        Yii::$app->session->addFlash('success', 'Cache Cleared');
        return $this->goBack();
    }
}
