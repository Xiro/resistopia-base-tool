<?php

namespace app\api;

use yii\base\BootstrapInterface;

/**
 * api module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\web\UrlRule',
                'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>',
                'route' => $this->id . '/<controller>/<action>'
            ],
        ], false);
//        if ($app instanceof \yii\web\Application) {
//            $app->getUrlManager()->addRules([
//                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
//                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
//                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
//            ], false);
//        } elseif ($app instanceof \yii\console\Application) {
//            $app->controllerMap[$this->id] = [
//                'class' => 'yii\gii\console\GenerateController',
//                'generators' => array_merge($this->coreGenerators(), $this->generators),
//                'module' => $this,
//            ];
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
