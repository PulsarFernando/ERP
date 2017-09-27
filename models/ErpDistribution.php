<?php
namespace app\models;
use Yii;
class ErpDistribution extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_DISTRIBUTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_DISTRIBUTION_PT', 'STR_DISTRIBUTION_EN'], 'required'],
            [['STR_DISTRIBUTION_PT', 'STR_DISTRIBUTION_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_DISTRIBUTION' => Yii::t('erpModel', 'ANTIGO uso_distribuicao'),
            'STR_DISTRIBUTION_PT' => Yii::t('erpModel', 'Str  Distribution  Pt'),
            'STR_DISTRIBUTION_EN' => Yii::t('erpModel', 'Str  Distribution  En'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_DISTRIBUTION_ID' => 'INT_PK_ID_ERP_DISTRIBUTION']);
    }
}
