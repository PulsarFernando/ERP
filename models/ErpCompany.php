<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
class ErpCompany extends ActiveRecord
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
            [['INT_ID_TEMP','STR_CNPJ'], 'integer'],
            [['STR_CNPJ'], 'string', 'max' => 14],
            [['STR_SOCIAL_REASON', 'STR_FANTASY_NAME'], 'string', 'max' => 100],
            [['STR_STATE_REGISTRATION'], 'string', 'max' => 20],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_COMPANY' => 'Código da empresa',
            'STR_CNPJ' => 'CNPJ',
            'STR_SOCIAL_REASON' => 'Razão social',
            'STR_FANTASY_NAME' => 'Nome Fantasia',
            'STR_STATE_REGISTRATION' => 'Inscrição estadual',
            'INT_ID_TEMP' => 'Código temporário',
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
    public function getErpCompanyWithDistinctSocialReason()
    {
    	return ArrayHelper::map(
    			ErpCompany::find()->asArray()->all(),
    			'INT_PK_ID_ERP_COMPANY',
    			'STR_SOCIAL_REASON'
    			);
    }
}