<?php

namespace app\components;

use app\models\AccessKey;
use app\models\AccessRight;
use app\models\User;
use mate\yii\widgets\SelectData;
use yii\base\Component;

class Access extends Component
{

    public static $actionAliases = [
        'confirm-delete' => 'delete',
        'index'          => 'view',
    ];

    /**
     * checks the active users right to access a feature
     * keys should usually be in the format controller/action
     * or controller/action/specification
     * @param $key
     * @param bool $default
     * @param bool $allowGuest
     * @return bool
     */
    public static function to($key, $default = true, $allowGuest = false)
    {
//        return true;

        static $user = false;
        if ($user === false) {
            $user = AccessRule::activeUser(false);
        }

        if (!$user) {
            return $allowGuest;
        }

        return self::ofUser($user, $key, $default = true, $allowGuest = false);
    }

    /**
     * checks a users right to access a feature
     * keys should usually be in the format controller/action
     * or controller/action/specification
     * @param User $user
     * @param $key
     * @param bool $default
     * @param bool $allowGuest
     * @return bool
     */
    public static function ofUser(User $user, $key, $default = true, $allowGuest = false)
    {
        static $rights = false;
        if ($rights === false) {
            $rights = SelectData::fromModel(
                AccessRight::class,
                "key",
                "id"
            );
        }

        if($user->is_admin == 1) {
            return true;
        }

        $keyParts = explode("/", $key);
        if(isset($keyParts[1]) && isset(self::$actionAliases[$keyParts[1]])) {
            $keyParts[1] = self::$actionAliases[$keyParts[1]];
            $key = implode('/', $keyParts);
        }

        if (!isset($rights[$key])) {
            return $default;
        }

        $accessList = AccessKey::findAccessList($user->access_key_id);
        return isset($accessList[$key]);
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