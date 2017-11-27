<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpState extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_STATE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_COUNTRY_ID', 'STR_STATE_EN', 'STR_STATE_ACRONYM', 'STR_STATE_PT'], 'required'],
            [['INT_FK_ERP_COUNTRY_ID'], 'integer'],
            [['STR_STATE_EN', 'STR_STATE_PT'], 'string', 'max' => 100],
            [['STR_STATE_ACRONYM'], 'string', 'max' => 2],
            [['INT_FK_ERP_COUNTRY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCountry::className(), 'targetAttribute' => ['INT_FK_ERP_COUNTRY_ID' => 'INT_PK_ID_ERP_COUNTRY']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_STATE' => Yii::t('erpModel', 'Int  Pk  Id  Erp  State'),
            'INT_FK_ERP_COUNTRY_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Country  ID'),
            'STR_STATE_EN' => Yii::t('erpModel', 'Str  State  En'),
            'STR_STATE_ACRONYM' => Yii::t('erpModel', 'Str  State  Acronym'),
            'STR_STATE_PT' => Yii::t('erpModel', 'Str  State  Pt'),
        ];
    }
    public function getErpCity()
    {
        return $this->hasMany(ErpCity::className(), ['INT_FK_ERP_STATE_ID' => 'INT_PK_ID_ERP_STATE']);
    }
    public function getErpCountry()
    {
        return $this->hasOne(ERPCOUNTRY::className(), ['INT_PK_ID_ERP_COUNTRY' => 'INT_FK_ERP_COUNTRY_ID']);
    }
    public function getErpState($arrParam)
    {
    	return ArrayHelper::map(
    		ErpState::find()->where($arrParam)->asArray()->all(),
    		'INT_PK_ID_ERP_STATE',
    		'STR_STATE_PT'
    	);
    }
    public function getErpStateByParam($arrParam)
    {
    	return ErpState::find()->where($arrParam)->one();
    }
    public function getStateCountryByIdCity($intIdCity)
    {
    	return ErpState::find()->joinWith(['erpCity', 'erpCountry'])->where([ErpCity::tableName().'.INT_PK_ID_ERP_CITY' => $intIdCity])->one();
    }
}