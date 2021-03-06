<?php


namespace app\controllers;

use app\models\Staff;
use app\models\StaffBackground;
use Yii;
use app\models\forms\StaffForm;
use yii\filters\AccessControl;
use yii\web\Controller;

class CharacterRegistrationController extends Controller
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
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->layout = 'blank';
    }

    public function actionIndex()
    {
        return $this->redirect(['select']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSelect()
    {
        $model = new Staff();
        if ($model->load(Yii::$app->request->post())) {
            if (Staff::findOne($model->sid)) {
                return $this->redirect(['update', 'id' => $model->sid]);
            } else {
                $model->addError('sid', 'SID could not be found');
            }
        }
        return $this->render('select', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $staff = new StaffForm();
        $staff->status_alive = 1;
        $background = new StaffBackground();

        $post = Yii::$app->request->post();
        if (
            $background->load($post)
            && $staff->load($post)
            && $staff->save()
        ) {
            $background->sid = $staff->sid;
            if ($background->save()) {
                return $this->redirect(['finish', 'id' => $staff->sid]);
            }
        }

        return $this->render('create', [
            "staff"      => $staff,
            "background" => $background
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $staff = StaffForm::findOne($id);
        $background = $staff->staffBackground ? $staff->staffBackground : new StaffBackground();

        $post = Yii::$app->request->post();
        if (
            $background->load($post)
            && $staff->load($post)
            && $staff->save()
        ) {
            $background->sid = $staff->sid;
            if ($background->save()) {
                return $this->redirect(['finish', 'id' => $staff->sid]);
            }
        }

        return $this->render('update', [
            "staff"      => $staff,
            "background" => $background,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionFinish($id)
    {
        $model = StaffForm::findOne($id);
        return $this->render('finish', ["model" => $model]);
    }

}