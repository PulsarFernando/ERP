<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpCity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CITY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_STATE_ID', 'STR_CITY_PT', 'STR_CITY_EN'], 'required'],
            [['INT_FK_ERP_STATE_ID'], 'integer'],
            [['STR_CITY_PT', 'STR_CITY_EN'], 'string', 'max' => 100],
            [['INT_FK_ERP_STATE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpState::className(), 'targetAttribute' => ['INT_FK_ERP_STATE_ID' => 'INT_PK_ID_ERP_STATE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_CITY' => Yii::t('erpModel', 'Int  Pk  Id  Erp  City'),
            'INT_FK_ERP_STATE_ID' => Yii::t('erpModel', 'Int  Fk  Erp  State  ID'),
            'STR_CITY_PT' => Yii::t('erpModel', 'Str  City  Pt'),
            'STR_CITY_EN' => Yii::t('erpModel', 'Str  City  En'),
        ];
    }
    public function getErpAuthor()
    {
        return $this->hasMany(ErpAuthor::className(), ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']);
    }
    public function getIntFkErpState()
    {
        return $this->hasOne(ErpState::className(), ['INT_PK_ID_ERP_STATE' => 'INT_FK_ERP_STATE_ID']);
    }
    public function getErpCustomer()
    {
        return $this->hasMany(ErpCustomer::className(), ['INT_FK_CUSTOMER_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']);
    }
    public function getErpLui()
    {
        return $this->hasMany(ErpLui::className(), ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']);
    }
    public function getSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']);
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']);
    }
    public function getErpCity()
    {
    	return ArrayHelper::map(
    		ErpCity::find()->asArray()->all(),
    		'INT_PK_ID_ERP_CITY',
    		'STR_CITY_PT'
    	);
    }
    public function getErpCityByFkStateId($intFkSate)
    {
    	return ArrayHelper::map(
    		ErpCity::find()->where(['INT_FK_ERP_STATE_ID' => $intFkSate])->asArray()->all(),
    		'INT_PK_ID_ERP_CITY',
    		'STR_CITY_PT'
    	);
    }
    public function getErpCityByParam($arrParam)
    {
    	return ErpCity::find()->where($arrParam)->one();
    }
}