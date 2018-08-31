<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\console\Application;

/**
 * This is the model class for table "changelog".
 *
 * @property string $id
 * @property string $object
 * @property string $primary_key
 * @property string $data
 * @property string $created
 * @property string $type
 * @property integer $user_id
 * @property string $hostname
 *
 * @property User $user
 */
class Changelog extends ActiveRecord
{
    /**
     * @var ActiveRecord
     */
    public $relatedObject;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'changelog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created'], 'safe'],
            [['user_id'], 'integer'],
            [['object', 'type', 'hostname'], 'string', 'max' => 191],
            [['primary_key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object' => 'Object',
            'primary_key' => 'Primary Key',
            'data' => 'Data',
            'created' => 'Created',
            'type' => 'Type',
            'user_id' => 'User',
            'hostname' => 'Hostname',
        ];
    }

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function beforeSave($insert)
    {
        if (empty($this->userId) && !(\Yii::$app instanceof Application) && !\Yii::$app->user->isGuest) {
            $this->user_id = \Yii::$app->user->id;
        }

        if (empty($this->hostname) && \Yii::$app->request->hasMethod('getUserIP')) {
            $this->hostname = \Yii::$app->request->getUserIP();
        }

        if (!empty($this->data) && is_array($this->data)) {
            $this->data = json_encode($this->data);
        }

        if ($this->relatedObject) {
            /** @var ActiveRecord $objectClass */
            $objectClass = get_class($this->relatedObject);
            $this->object = Inflector::id2camel($objectClass::tableName());
            $this->primary_key = $this->relatedObject->primaryKey;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
