<?php

namespace app\components;

use app\models\AccessRight;
use mate\yii\widgets\SelectData;
use yii\base\Component;

class Access extends Component
{

    public static $actionAliases = [
        'confirm-delete' => 'delete',
        'index'          => 'view',
    ];

    /**
     * checks a users right to access a feature
     * keys should usually be in the format controller/action
     * or controller/action/specification
     * @param $key
     * @param bool $default
     * @param bool $allowGuest
     * @return bool
     */
    public static function to($key, $default = true, $allowGuest = false)
    {
        static $bits = false;
        if ($bits === false) {
            $bits = SelectData::fromModel(
                AccessRight::class,
                "key",
                "id"
            );
        }

        static $user = false;
        if ($user === false) {
            $user = AccessRule::activeUser(false);
        }

        if (!$user) {
            return $allowGuest;
        }

        $keyParts = explode("/", $key);
        if(isset($keyParts[1]) && isset(self::$actionAliases[$keyParts[1]])) {
            $keyParts[1] = self::$actionAliases[$keyParts[1]];
            $key = implode('/', $keyParts);
        }

        if (!isset($bits[$key])) {
            return $default;
        }

        $accessKey = $user->accessKey->access_key;
        return (bool)((1 << $bits[$key] - 1) & $accessKey);
    }

    /**
     * adds the given item under the condition, that the user can access its url
     * @param array $item
     * @param array $navItems
     */
    public static function addNavItem(array $item, array &$navItems)
    {
        $url = isset($item['url']) ? $item['url'] : [];
        $accessKey = isset($url[0]) ? $url[0] : null;

        if($accessKey && self::to($accessKey)) {
            $navItems[] = $item;
        }
    }

}