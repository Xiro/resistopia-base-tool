<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_treatment_injury".
 *
 * @property integer $id
 * @property integer $treatment_id
 * @property double $x
 * @property double $y
 * @property string $injury
 * @property string $operation
 * @property string $annotation
 *
 * @property MedicineTreatment $treatment
 */
class MedicineTreatmentInjury extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_treatment_injury';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['treatment_id', 'x', 'y', 'injury'], 'required'],
            [['treatment_id'], 'integer'],
            [['x', 'y'], 'number'],
            [['injury'], 'string'],
            [['operation', 'annotation'], 'string', 'max' => 255],
            [['treatment_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineTreatment::className(), 'targetAttribute' => ['treatment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'treatment_id' => 'Treatment ID',
            'x' => 'X',
            'y' => 'Y',
            'injury' => 'Injury',
            'operation' => 'Operation',
            'annotation' => 'Annotation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreatment()
    {
        return $this->hasOne(MedicineTreatment::className(), ['id' => 'treatment_id']);
    }
}
