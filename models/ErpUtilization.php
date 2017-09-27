<?php
namespace app\models;
use Yii;
class ErpUtilization extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_UTILIZATION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_UTILIZATION_PT', 'STR_UTILIZATION_EN'], 'required'],
            [['STR_UTILIZATION_PT', 'STR_UTILIZATION_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_UTILIZATION' => Yii::t('erpModel', 'USO_SUBTIPO'),
            'STR_UTILIZATION_PT' => Yii::t('erpModel', 'Str  Utilization  Pt'),
            'STR_UTILIZATION_EN' => Yii::t('erpModel', 'Str  Utilization  En'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_UTILIZATION_ID' => 'INT_PK_ID_ERP_UTILIZATION']);
    }
}