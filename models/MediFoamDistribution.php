<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medi_foam_distribution".
 *
 * @property integer $id
 * @property string $recipient_rpn
 * @property string $issued_by_rpn
 * @property integer $mk1_issued
 * @property integer $mk1_returned
 * @property string $created
 *
 * @property Staff $recipient
 * @property Staff $issuedBy
 */
class MediFoamDistribution extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medi_foam_distribution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient_rpn', 'issued_by_rpn'], 'required'],
            [['mk1_issued', 'mk1_returned'], 'integer'],
            [['created'], 'safe'],
            [['recipient_rpn', 'issued_by_rpn'], 'string', 'max' => 8],
            [['recipient_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['recipient_rpn' => 'rpn']],
            [['issued_by_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['issued_by_rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient_rpn' => 'Empfänger',
            'issued_by_rpn' => 'Ausgegeben von',
            'mk1_issued' => 'Mk1 ausgegeben',
            'mk1_returned' => 'Mk1 zurückgegeben',
            'created' => 'Erstellt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'recipient_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssuedBy()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'issued_by_rpn']);
    }
}
