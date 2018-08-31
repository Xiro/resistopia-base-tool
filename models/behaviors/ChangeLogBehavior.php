<?php

namespace app\models\behaviors;

use app\models\Changelog;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class ChangeLogBehavior
 * @package common\modules\eventLogger\behaviors
 *
 * @property array $labels
 */
class ChangeLogBehavior extends Behavior
{
    /**
     * @var array
     */
    public $excludedAttributes = [];

    /**
     * @var string
     */
    public $type = 'update';

    /**
     * @return array
     */
    const DELETED = 'deleted';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'addLog',
            ActiveRecord::EVENT_AFTER_INSERT => 'addLog',
            ActiveRecord::EVENT_BEFORE_DELETE => 'addDeleteLog',
        ];
    }

    /**
     * @param \yii\base\Event $event
     */
    public function addLog(Event $event)
    {
        /**  @var ActiveRecord $owner */
        $owner = $this->owner;
        $changedAttributes = $event->changedAttributes;

        $relations = $this->getRelations();
        $diff = [];

        foreach ($changedAttributes as $attrName => $attrVal) {
            $newAttrVal = $owner->getAttribute($attrName);

            //avoid float compare
            $newAttrVal = is_float($newAttrVal) ? StringHelper::floatToString($newAttrVal) : $newAttrVal;
            $attrVal = is_float($attrVal) ? StringHelper::floatToString($attrVal) : $attrVal;

            if ($newAttrVal != $attrVal) {
                $changes = [$attrVal, $newAttrVal];
                $changes = $this->processForeignKeyAttributes($attrName, $changes, $relations);
                $diff[$attrName] = $changes;
            }
        }
        $diff = $this->applyExclude($diff);

        if ($diff) {
            $logEvent = new Changelog();
            $logEvent->relatedObject = $owner;
            $logEvent->data = $diff;
            $logEvent->type = $this->type;
            $logEvent->save();
        }
    }

    /**
     * @return array
     */
    private function getRelations()
    {
        /**  @var ActiveRecord $ownerClass */
        $ownerClass = get_class($this->owner);
        $foreignKeys = $ownerClass::getTableSchema()->foreignKeys;
        $relations = [];
        foreach ($foreignKeys as $properties) {
            $relationAttr = current($properties);
            next($properties);
            $foreignKeyAttr = key($properties);
            $relations[$foreignKeyAttr] = lcfirst(Inflector::id2camel(str_replace('_', '-', $relationAttr)));
        }
        return $relations;
    }

    /**
     * Will check if associated models can be stored as strings instead of their primary keys
     * @param string $attrName
     * @param array $changes
     * @param array $relations
     * @return array
     */
    private function processForeignKeyAttributes($attrName, array $changes, array $relations)
    {
        /**  @var ActiveRecord $owner */
        $owner = $this->owner;
        $attrVal = $changes[0];
        $newAttrVal = $changes[1];
        if(!isset($relations[$attrName])) {
            return $changes;
        }
        $relationAttr = $relations[$attrName];
        $relationGetter = 'get' . ucfirst($relationAttr);
//        echo '<pre>';
//        echo print_r(array(
//            $owner->hasMethod($relationGetter),
//            $owner->$relationGetter() instanceof ActiveQuery
//        ));
//        echo '</pre>';
        if(!$owner->hasMethod($relationGetter) || !$owner->$relationGetter() instanceof ActiveQuery) {
            return $changes;
        }
        /** @var ActiveRecord $relatedObjClass */
        $relatedObjClass = $owner->$relationGetter()->modelClass;
        /** @var ActiveRecord $relatedObj */
        $relatedObj = new $relatedObjClass();
        $nameAttr = $relatedObj->hasProperty('name') ? "name" : false;
        $nameAttr = $relatedObj->hasProperty('title') ? "title" : $nameAttr;
//        echo '<pre>';
//        echo print_r(array(
//            $nameAttr
//        ));
//        echo '</pre>';
        if(!$nameAttr) {
            return $changes;
        }
        $oldRelatedObj = $relatedObjClass::findOne($attrVal);
        if($oldRelatedObj) {
            $attrVal = $oldRelatedObj->$nameAttr;
        }
        $newRelatedObj = $relatedObjClass::findOne($newAttrVal);
        if($newRelatedObj) {
            $newAttrVal = $newRelatedObj->$nameAttr;
        }
        return [$attrVal, $newAttrVal];
    }

    /**
     * @param $data
     * @param $type
     */
    public function addCustomLog($data, $type = null)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        if ($type) {
            $this->setType($type);
        }

        $logEvent = new Changelog();
        $logEvent->data = $data;
        $logEvent->type = $this->type;
        $logEvent->save();
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param array $diff
     *
     * @return array
     */
    private function applyExclude(array $diff)
    {
        foreach ($this->excludedAttributes as $attr) {
            unset($diff[$attr]);
        }

        return $diff;
    }

    /**
     * @param array $diff
     *
     * @return array
     */
    public function setChangelogLabels(array $diff)
    {
        return $diff;
    }

    public function addDeleteLog()
    {
        $logEvent = new Changelog();
        $logEvent->relatedObject = $this->owner;
        $logEvent->data = '';
        $logEvent->type = self::DELETED;
        $logEvent->save();
    }
}
