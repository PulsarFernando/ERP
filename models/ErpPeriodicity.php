<?php
namespace app\models;
use Yii;
class ErpPeriodicity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_PERIODICITY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_PERIODICITY_PT', 'STR_PERIODICITY_EN'], 'required'],
            [['STR_PERIODICITY_PT', 'STR_PERIODICITY_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_PERIODICITY' => Yii::t('erpModel', 'Antiga Periodicidade'),
            'STR_PERIODICITY_PT' => Yii::t('erpModel', 'Str  Periodicity  Pt'),
            'STR_PERIODICITY_EN' => Yii::t('erpModel', 'Str  Periodicity  En'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_PERIODICITY_ID' => 'INT_PK_ID_ERP_PERIODICITY']);
    }
}