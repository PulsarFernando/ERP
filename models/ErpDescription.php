<?php
namespace app\models;
use Yii;
class ErpDescription extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_DESCRIPTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_DESCRIPTION_PT', 'STR_DESCRIPTION_EN'], 'required'],
            [['STR_DESCRIPTION_PT', 'STR_DESCRIPTION_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_DESCRIPTION' => Yii::t('erpModel', 'ANTIGO TAMANHO'),
            'STR_DESCRIPTION_PT' => Yii::t('erpModel', 'Str  Description  Pt'),
            'STR_DESCRIPTION_EN' => Yii::t('erpModel', 'Str  Description  En'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_DESCRIPTION_ID' => 'INT_PK_ID_ERP_DESCRIPTION']);
    }
}