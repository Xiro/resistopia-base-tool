<?php

namespace app\helpers;

use app\components\Access;
use app\models\AccessBit;
use mate\yii\widgets\SelectData;

class Html extends \yii\helpers\Html
{

    /**
     * Returns null if user does not have access to the linked page
     * @param string $text
     * @param null $url
     * @param array $options
     * @return null|string
     */
    public static function a($text, $url = null, $options = [])
    {
        if (is_array($url) && isset($url[0])) {
            $accessKey = $url[0];

            $keyParts = explode('/', $url[0]);
            if(count($keyParts) === 1) {
                array_unshift($keyParts,  \Yii::$app->controller->id);
                $accessKey = implode('/', $keyParts);
            }

            if(!Access::to($accessKey, true, true)) {
                return null;
            }
        }
        return parent::a($text, $url, $options);
    }


}