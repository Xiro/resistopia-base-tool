<?php

namespace app\models\form;

use yii\base\Model;
use yii\db\ActiveRecord;


trait UpdateToManyTrait
{

    protected function updateToMany($relationName, $modelClass, $selectedIds, $delete = false)
    {
        /** @var Model $this */
        if(!$this instanceof Model) {
            throw new \RuntimeException("Class using UpdateManyToManyTrait should extend " . Model::className());
        }
        $selectedIds = empty($selectedIds) ? array() : $selectedIds;
        /** @var ActiveRecord $modelClass */

        $existing = [];
        foreach ($this->$relationName as $relatedModel) {
            $existing[$relatedModel->id] = $relatedModel;
        }
        $existingIds = array_keys($existing);

        $removeIds = array_diff($existingIds, $selectedIds);
        foreach ($removeIds as $removeId) {
            $this->unlink($relationName, $existing[$removeId], $delete);
        }

        $addIds = array_diff($selectedIds, $existingIds);

        foreach ($addIds as $addId) {
            $linkModel = $modelClass::findOne($addId);
            if(!$linkModel) {
                throw new \InvalidArgumentException("$modelClass with ID $addId does not exist");
            }
            $this->link($relationName, $linkModel);
        }
    }

}