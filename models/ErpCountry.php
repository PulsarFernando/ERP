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
            [['STR_COUNTRY_PT', 'STR_COUNTRY_EN', 'STR_COUNTRY_ACRONYM', 'INT_DDI'], 'required'],
            [['STR_COUNTRY_PT', 'STR_COUNTRY_EN'], 'string', 'max' => 100],
            [['STR_COUNTRY_ACRONYM'], 'string', 'max' => 2],
        	[['INT_DDI'], 'integer', 'max' => 3],	
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_COUNTRY' => Yii::t('erpModel', 'Código do pais'),
            'STR_COUNTRY_PT' => Yii::t('erpModel', 'Pais'),
            'STR_COUNTRY_EN' => Yii::t('erpModel', 'Coutry Name'),
            'STR_COUNTRY_ACRONYM' => Yii::t('erpModel', 'Sigla do país'),
        	'INT_DDI' => 'DDI'
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
    public function getErpCountryByParam($arrParam)
    {
    	return ErpCountry::find()->where($arrParam)->one();
    }
}
