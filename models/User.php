<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $rpn
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $access_key_id
 * @property string $created
 * @property string $updated
 *
 * @property AccessKey $accessKey
 * @property Staff $staff
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_hash', 'auth_key', 'access_key_id'], 'required'],
            [['access_key_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['rpn'], 'string', 'max' => 8],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['auth_key'], 'unique'],
            [['rpn'], 'unique'],
            [['access_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessKey::class, 'targetAttribute' => ['access_key_id' => 'id']],
            [['rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rpn' => 'Rpn',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'access_key_id' => 'Access Key',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findByRpn($rpn)
    {
        return static::findOne(['rpn' => $rpn]);
    }

    /**
     * @throws NotSupportedException
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKey()
    {
        return $this->hasOne(AccessKey::class, ['id' => 'access_key_id']);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::class, ['rpn' => 'rpn']);
    }
}
