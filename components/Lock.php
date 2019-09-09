<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Url;
use yii\web\Application;

class Lock extends Component
{

    static $allowed = [
        'site/lock',
        'site/unlock',
        'site/is-locked'
    ];

    /**
     * Bind the checkup message to before any action is executed
     */
    public function init() {
        Yii::$app->on(Application::EVENT_BEFORE_ACTION, [$this, 'checkLockRedirect']);
    }

    /**
     * Shows system failure page if the system is locked and ends all further executions
     */
    public function checkLockRedirect()
    {
        $checkLockUrl = Url::to(['site/is-locked']);
        Yii::$app->view->registerJs("var checkLockUrl = '{$checkLockUrl}';");

        $controller = Yii::$app->controller;
        $route = $controller->id . '/' . $controller->action->id;
        if (self::isLocked() && !in_array($route, self::$allowed)) {
            Yii::$app->controller->layout = 'blank';
            echo Yii::$app->controller->render('../site/lock');
            exit;
        }
    }

    /**
     * Simulates a system failure. Start and end times can be given to plan a failure
     * @param null $start
     * @param null $end
     */
    public static function lock($start = null, $end = null)
    {
        Yii::$app->cache->set('system-lock', [
            'start' => $start ? strtotime($start) : time(),
            'end' => $end ? strtotime($end) : time() * 2,
        ]);
    }

    /**
     * End the current system failure simulation
     */
    public static function unlock()
    {
        Yii::$app->cache->delete('system-lock');
    }

    /**
     * check if a system failure is currently simulated
     * @return bool
     */
    public static function isLocked() {
        $lock = Yii::$app->cache->get('system-lock');
        if ($lock && $lock['start'] <= time() && $lock['end'] >= time()) {
            return true;
        }
        return false;
    }

}