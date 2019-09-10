<?php

namespace app\controllers;

use app\components\AccessRule;
use app\components\Lock;
use app\models\AccessMask;
use app\models\AccessRight;
use app\models\AccessCategory;
use app\models\Section;
use app\models\Staff;
use mate\yii\components\SelectData;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Inflector;
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
                'class'      => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::class
                ],
                'rules'      => [
                    [
                        'actions' => ['is-locked'],
                        'allow'   => true,
                    ],
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
        return $this->render('index');
    }

    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->addFlash('success', 'Cache Cleared');
        return $this->goBack();
    }

    /**
     * Simulates a system failure. Start and end times can be given to plan a failure
     * @param null $start
     * @param null $end
     * @return string
     */
    public function actionLock($start = null, $end = null)
    {
        Lock::lock($start, $end);
        return $this->goBack();
    }

    /**
     * End a simulated system failure
     * @return Response
     */
    public function actionUnlock()
    {
        Lock::unlock();
        return $this->goBack();
    }

    /**
     * Returns 1 if the system is locked and 0 if it's not
     * @return int
     */
    public function actionIsLocked()
    {
        return Lock::isLocked() ? 1 : 0;
    }
}
