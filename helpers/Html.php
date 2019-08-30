<?php

namespace app\helpers;

use app\components\Access;
use app\models\AccessRight;
use app\models\Staff;
use mate\yii\widgets\SelectData;
use mate\yii\widgets\Glyphicon;

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
            if (count($keyParts) === 1) {
                array_unshift($keyParts, \Yii::$app->controller->id);
                $accessKey = implode('/', $keyParts);
            }

            if (!Access::to($accessKey, true, true)) {
                return null;
            }
        }
        return parent::a($text, $url, $options);
    }

    /**
     * Returns a staff name with a view-Icon
     * @param $staff
     * @param string $labelAttribute
     * @param string $emptyLabel
     * @return string
     */
    public static function staffLabel($staff, $labelAttribute = 'nameWithRpn', $emptyLabel = 'n/a')
    {
        if(!$staff instanceof Staff) {
            return $emptyLabel;
        }
        return $staff->$labelAttribute . ' ' . Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $staff->sid],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        );
    }

}