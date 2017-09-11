<?php


namespace app\components;

use app\models\Staff;
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
        /** @var Staff $staffModel */
        $staffModel = $user->identity;

        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
                // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $staffModel->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param bool $beStrict
     * @return Staff|IdentityInterface
     */
    public static function activeStaff($beStrict = true)
    {
        $activeStaff = \Yii::$app->user->identity;
        if ($beStrict && !$activeStaff) {
            throw new \RuntimeException("User not logged in");
        }
        return $activeStaff;
    }
}