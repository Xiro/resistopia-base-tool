<?php

namespace app\api\controllers;

use app\components\Access;
use app\models\Staff;
use mate\yii\widgets\JsonResponse;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class StaffController extends Controller
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

    public function actionView($rpn)
    {
        $staff = Staff::find()
            ->where(['rpn' => $rpn])
            ->joinWith([
                'missionBlocks',
                'baseCategory',
                'bloodType',
                'citizenship',
                'company',
                'eyeColor',
                'rank',
                'specialFunction',
                'team',
            ])
            ->asArray()
            ->one();
        if (!$staff) {
            return JsonResponse::error('Not found');
        }
        return JsonResponse::success('Found', ['data' => $staff]);
    }

    public function actionAccessList($rpn)
    {
        $staff = Staff::findOne($rpn);
        if (!$staff || !$staff->accessKey) {
            return JsonResponse::error('Not found');
        }
        $accessList = array_flip($staff->accessKey->getAccessList());
        return JsonResponse::success('Access list found', ['data' => $accessList]);
    }

    public function actionHasAccess($rpn, $accessKey)
    {
        $staff = Staff::findOne($rpn);
        if (!$staff) {
            return JsonResponse::error('Rpn not found');
        }
        if (!$staff->user) {
            return JsonResponse::error('Staff does not have a login');
        }
        return JsonResponse::success('Access right retrieved', ['data' => [
            'isAllowed' => Access::ofUser($staff->user, $accessKey)
        ]]);
    }

}