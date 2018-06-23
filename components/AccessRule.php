<?php


namespace app\components;

use Yii;
use app\models\Staff;
use app\models\User;
use yii\web\IdentityInterface;

class AccessRule extends \yii\filters\AccessRule
{

    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '§') {
                $controller = Yii::$app->controller->id;
                $action = Yii::$app->controller->action->id;

                return Access::to($controller . '/' . $action);
            }
        }

        return false;
    }

    /**
     * @param bool $beStrict
     * @return User|IdentityInterface
     */
    public static function activeUser($beStrict = true)
    {
        $activeUser = \Yii::$app->user->identity;
        if ($beStrict && !$activeUser) {
            throw new \RuntimeException("User not logged in");
        }
        return $activeUser;
    }

    /**
     * @param bool $beStrict
     * @return Staff|IdentityInterface
     */
    public static function activeStaff($beStrict = true)
    {
        $activeUser = self::activeUser($beStrict);
        if(!$activeUser) {
            return null;
        }
        $activeStaff = $activeUser->staff;
        if ($beStrict && !$activeStaff) {
            throw new \RuntimeException("User not logged in or user has no staff entry");
        }
        return $activeStaff;
    }
}