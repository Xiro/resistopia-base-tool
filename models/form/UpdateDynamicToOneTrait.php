<?php


namespace app\models\form;

use yii\db\ActiveRecord;

trait UpdateDynamicToOneTrait
{

    public function updateDynamicToOne($idColumn, $modelClass, $value, $modelValueAttr = "name")
    {
        if(!$value) {
            return null;
        }
        /** @var ActiveRecord $modelClass */
        $hasModel = 0 < $modelClass::find()->where(["id" => $value])->count();
        if($hasModel) {
            $this->$idColumn = $value;
        } else {
            /** @var ActiveRecord $addModel */
            $addModel = new $modelClass;
            $addModel->$modelValueAttr = $value;
            $addModel->save();
            $this->$idColumn = $addModel->id;
        }
    }

}