<?php

namespace app\models;

use app\helpers\DebugSql;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $sid
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property string $token_expire
 * @property integer $access_key_id
 * @property integer $approved;
 * @property integer $is_admin
 * @property string $created
 * @property string $updated
 *
 * @property string $identity
 *
 * @property AccessKey $accessKey
 * @property Staff $staff
 */
class User extends ActiveRecord implements IdentityInterface
{

    const TOKEN_EXPIRE_IN_SECONDS = 3600;

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
            [['access_key_id', 'approved'], 'integer'],
            [['created', 'updated', 'token_expire'], 'safe'],
            [['sid'], 'string', 'max' => 8],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['access_token'], 'unique'],
            [['auth_key'], 'unique'],
            [['sid'], 'unique'],
            [['access_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessKey::class, 'targetAttribute' => ['access_key_id' => 'id']],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'sid'           => 'SID',
            'password_hash' => 'Password Hash',
            'auth_key'      => 'Auth Key',
            'access_key_id' => 'Access Key',
            'approved'      => 'Approved',
            'created'       => 'Created',
            'updated'       => 'Updated',
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
    public static function findBySid($sid)
    {
        return static::findOne(['sid' => $sid]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var User $user */
        $user = self::find()
            ->where(['access_token' => $token])
            ->andWhere(['>=', 'token_expire', date('Y-m-d H:i:s', time())])
            ->one();
        if ($user) {
            $user->token_expire = date('Y-m-d H:i:s', time() + self::TOKEN_EXPIRE_IN_SECONDS);
            $user->save();
        }
        return $user;
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
        $this->token_expire = date('Y-m-d H:i:s', time() + self::TOKEN_EXPIRE_IN_SECONDS);
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
     * @return string
     */
    public function getIdentity()
    {
        return $this->sid ? $this->sid : 'API User #' . $this->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::class, ['sid' => 'sid']);
    }
}
