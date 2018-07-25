<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_checkup_injury".
 *
 * @property integer $id
 * @property integer $checkup_id
 * @property double $x
 * @property double $y
 * @property string $injury
 * @property string $annotation
 *
 * @property MedicineCheckup $checkup
 */
class MedicineCheckupInjury extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_checkup_injury';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checkup_id', 'x', 'y', 'injury'], 'required'],
            [['checkup_id'], 'integer'],
            [['x', 'y'], 'number'],
            [['injury'], 'string'],
            [['annotation'], 'string', 'max' => 255],
            [['checkup_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineCheckup::className(), 'targetAttribute' => ['checkup_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checkup_id' => 'Checkup ID',
            'x' => 'X',
            'y' => 'Y',
            'injury' => 'Verletzung',
            'annotation' => 'Anmerkung',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckup()
    {
        return $this->hasOne(MedicineCheckup::className(), ['id' => 'checkup_id']);
    }
}
