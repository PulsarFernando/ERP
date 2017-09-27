<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpCompany extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_COMPANY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_CNPJ', 'STR_SOCIAL_REASON', 'STR_FANTASY_NAME'], 'required'],
            [['INT_ID_TEMP'], 'integer'],
            [['STR_CNPJ'], 'string', 'max' => 14],
            [['STR_SOCIAL_REASON', 'STR_FANTASY_NAME'], 'string', 'max' => 100],
            [['STR_STATE_REGISTRATION'], 'string', 'max' => 20],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_COMPANY' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Company'),
            'STR_CNPJ' => Yii::t('erpModel', 'Str  Cnpj'),
            'STR_SOCIAL_REASON' => Yii::t('erpModel', 'Str  Social  Reason'),
            'STR_FANTASY_NAME' => Yii::t('erpModel', 'Str  Fantasy  Name'),
            'STR_STATE_REGISTRATION' => Yii::t('erpModel', 'Str  State  Registration'),
            'INT_ID_TEMP' => Yii::t('erpModel', 'Int  Id  Temp'),
        ];
    }
    public function getErpAuthor()
    {
        return $this->hasMany(ErpAuthor::className(), ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']);
    }
    public function getErpCustomer()
    {
        return $this->hasMany(ErpCustomer::className(), ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']);
    }
    public function getErpLicense()
    {
        return $this->hasMany(ErpLicense::className(), ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']);
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']);
    }
    public function getErpCompany()
    {
    	return ArrayHelper::map(
    			ErpCompany::find()->asArray()->all(), 
    			'INT_PK_ID_ERP_COMPANY', 
    			'STR_SOCIAL_REASON'
    	);
    }
}