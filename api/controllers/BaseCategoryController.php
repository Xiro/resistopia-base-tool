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

/**
 * @deprecated
 * Class BaseCategoryController
 * @package app\api\controllers
 */
class BaseCategoryController extends SectionController
{

}