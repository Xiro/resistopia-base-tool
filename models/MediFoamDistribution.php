<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medi_foam_distribution".
 *
 * @property integer $id
 * @property string $recipient_sid
 * @property string $issued_by_sid
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
            [['recipient_sid', 'issued_by_sid'], 'required'],
            [['mk1_issued', 'mk1_returned'], 'integer'],
            [['created'], 'safe'],
            [['recipient_sid', 'issued_by_sid'], 'string', 'max' => 8],
            [['recipient_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['recipient_sid' => 'sid']],
            [['issued_by_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['issued_by_sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient_sid' => 'Empfänger',
            'issued_by_sid' => 'Ausgegeben von',
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
        return $this->hasOne(Staff::className(), ['sid' => 'recipient_sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssuedBy()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'issued_by_sid']);
    }
}
