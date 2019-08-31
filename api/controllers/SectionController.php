<?php

namespace app\api\controllers;

use app\models\Section;
use app\models\Staff;
use mate\yii\widgets\JsonResponse;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class SectionController extends Controller
{
    public $modelClass = Staff::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                [
                    'class'   => HttpBearerAuth::class,
                    'header'  => 'access-token',
                    'pattern' => null
                ],
                QueryParamAuth::class,
                HttpBasicAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actionKeys()
    {
        $sections = Section::find()->all();
        $keyList = ArrayHelper::map($sections, 'name', 'key');
        return JsonResponse::success('List created', ['data' => $keyList]);
    }

}