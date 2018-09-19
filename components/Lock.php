<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\web\Application;

class Lock extends Component
{

    public function init() {
        Yii::$app->on(Application::EVENT_BEFORE_ACTION, [$this, 'checkLock']);
    }

    public function checkLock()
    {
        $lockFile = __DIR__ . '/../lock.txt';
        if(is_file($lockFile) && file_get_contents($lockFile) == 1) {
            Yii::$app->controller->layout = false;
            echo Yii::$app->controller->render('../site/lock');
            exit;
        }
    }

}