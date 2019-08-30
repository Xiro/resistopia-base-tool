<?php

namespace app\api\controllers;

use app\models\User;
use mate\yii\widgets\JsonResponse;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function actionSid()
    {
        $request = \Yii::$app->request;
        $sid = $request->post('sid');
        if(!$sid) {
            return JsonResponse::error('Missing POST parameter sid');
        }
        return $this->authByIdentifier('sid', $sid);
    }

    public function actionKey()
    {
        $request = \Yii::$app->request;
        $key = $request->post('key');
        if(!$key) {
            return JsonResponse::error('Missing POST parameter key');
        }
        return $this->authByIdentifier('auth_key', $key);
    }

    private function authByIdentifier($identifierColumn, $identifier)
    {
        $request = \Yii::$app->request;
        $user = User::findOne([$identifierColumn => $identifier]);
        if(!$user) {
            sleep(1);
            return JsonResponse::error('User not found');
        }
        $password = $request->post('password');
        if(!$password) {
            return JsonResponse::error('Missing POST parameter password');
        }
        $passwordValid = $user->validatePassword($password);
        if(!$passwordValid) {
            sleep(1);
            return JsonResponse::error('Incorrect password');
        }
        $user->generateAccessToken();
        if(!$user->save()) {
            return JsonResponse::error('Access token could not be generated', ['validation-errors' => $user->errors]);
        }

        return JsonResponse::success(
            'Authentication successful',
            ['access_token' => $user->access_token]
        );
    }

}