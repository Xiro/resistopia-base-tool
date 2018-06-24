<?php


namespace app\controllers;

use app\models\Staff;
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
                'class'      => AccessControl::class,
                'rules'      => [
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

    /**
     * @return string|\yii\web\Response
     */
    public function actionSelect()
    {
        $model = new Staff();
        if($model->load(Yii::$app->request->post())) {
            if(Staff::findOne($model->rpn)) {
                return $this->redirect(['update', 'id' => $model->rpn]);
            } else {
                $model->addError('rpn', 'Rpn could not be found');
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
        $model = new StaffForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['finish', 'id' => $model->rpn]);
        }

        return $this->render('create', ["model" => $model]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = StaffForm::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['finish', 'id' => $model->rpn]);
        }

        return $this->render('update', ["model" => $model]);
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