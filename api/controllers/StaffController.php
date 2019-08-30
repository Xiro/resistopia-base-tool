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

    public function actionView($sid)
    {
        $staff = Staff::find()
            ->where(['sid' => $sid])
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

    public function actionAccessList($sid)
    {
        $staff = Staff::findOne($sid);
        if (!$staff || !$staff->accessKey) {
            return JsonResponse::error('Not found');
        }
        $accessList = array_flip($staff->accessKey->getAccessList());
        return JsonResponse::success('Access list found', ['data' => $accessList]);
    }

    public function actionHasAccess($sid, $accessKey)
    {
        $staff = Staff::findOne($sid);
        if (!$staff) {
            return JsonResponse::error('SID not found');
        }
        if (!$staff->user) {
            return JsonResponse::error('Staff does not have a login');
        }
        return JsonResponse::success('Access right retrieved', ['data' => [
            'isAllowed' => Access::ofUser($staff->user, $accessKey)
        ]]);
    }

}