<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpCountry extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_COUNTRY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_COUNTRY_PT', 'STR_COUNTRY_EN', 'STR_COUNTRY_ACRONYM'], 'required'],
            [['STR_COUNTRY_PT', 'STR_COUNTRY_EN'], 'string', 'max' => 100],
            [['STR_COUNTRY_ACRONYM'], 'string', 'max' => 2],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_COUNTRY' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Country'),
            'STR_COUNTRY_PT' => Yii::t('erpModel', 'Str  Country  Pt'),
            'STR_COUNTRY_EN' => Yii::t('erpModel', 'Str  Country  En'),
            'STR_COUNTRY_ACRONYM' => Yii::t('erpModel', 'Str  Country  Acronym'),
        ];
    }
    public function getErpState()
    {
        return $this->hasMany(ErpState::className(), ['INT_FK_ERP_COUNTRY_ID' => 'INT_PK_ID_ERP_COUNTRY']);
    }
    public function getErpCountry()
    {
    	return ArrayHelper::map(
    		ErpCountry::find()->asArray()->all(),
    		'INT_PK_ID_ERP_COUNTRY',
    		'STR_COUNTRY_PT'
    	);
    }
}
