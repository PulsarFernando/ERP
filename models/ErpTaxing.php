<?php
namespace app\models;
use Yii;
class ErpTaxing extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_TAXING';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_TAXING'], 'required'],
            [['INT_PERCENTAGE'], 'integer'],
            [['STR_TAXING'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_TAXING' => Yii::t('erpModel', 'Int  Pk  Id  Taxing'),
            'STR_TAXING' => Yii::t('erpModel', 'Str  Taxing'),
            'INT_PERCENTAGE' => Yii::t('erpModel', 'Int  Percentage'),
        ];
    }
}