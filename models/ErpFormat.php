<?php
namespace app\models;
use Yii;
class ErpFormat extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_FORMAT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_FORMAT_PT', 'STR_FORMAT_EN'], 'required'],
            [['STR_FORMAT_PT', 'STR_FORMAT_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_FORMAT' => Yii::t('erpModel', 'ANTIGO FORMATO'),
            'STR_FORMAT_PT' => Yii::t('erpModel', 'Str  Format  Pt'),
            'STR_FORMAT_EN' => Yii::t('erpModel', 'Str  Format  En'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_FORMAT_ID' => 'INT_PK_ID_ERP_FORMAT']);
    }
}
