<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\web\Application;

class AjaxLayout extends Component
{

    public function init() {
        Yii::$app->on(Application::EVENT_BEFORE_ACTION, [$this, 'switchToAjaxLayout']);
    }

    public function switchToAjaxLayout()
    {
        if(Yii::$app->request->hasProperty("isAjax") && Yii::$app->request->isAjax) {
            Yii::$app->controller->layout = "ajax-html";
        }
    }

}