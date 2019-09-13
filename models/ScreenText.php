<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ScreenText extends Model
{
    /**
     * @var string Cache location for model data
     */
    public static $cacheKey = "screen-text";
    /**
     * @var string Heading for message
     */
    public $heading;
    /**
     * @var string Message to show in mission screen
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['heading', 'message'], 'safe'],
            [['heading'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'heading' => 'Heading',
            'message' => 'Message',
        ];
    }

    public function save()
    {
        return Yii::$app->cache->set(self::$cacheKey, $this->getAttributes());
    }

    /**
     * @return ScreenText
     */
    public static function read()
    {
        $data = Yii::$app->cache->get(self::$cacheKey);
        $modelClass = self::class;
        /** @var ScreenText $model */
        $model = new $modelClass();
        if($data) {
            $model->load(['ScreenText' => $data]);
        }
        return $model;
    }

}