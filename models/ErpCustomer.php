<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpCustomer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CUSTOMER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_CUSTOMER_ERP_CITY_ID', 'INT_FK_ERP_COMPANY_ID', 'BOO_STATUS'], 'integer'],
            [['INT_FK_ERP_COMPANY_ID', 'STR_ADDRESS', 'STR_ZIP_CODE'], 'required'],
            [['STR_NOTE'], 'string'],
            [['FLO_DISCOUNT_VALUE', 'FLO_DISCOUNT_PERCENTAGE'], 'number'],
            [['STR_ADDRESS'], 'string', 'max' => 100],
            [['STR_ZIP_CODE'], 'string', 'max' => 8],
            [['STR_DDI_PHONE', 'STR_DDD_PHONE'], 'string', 'max' => 2],
            [['STR_PHONE', 'STR_FAX'], 'string', 'max' => 10],
            [['STR_DDI_FAX', 'STR_DDD_FAX', 'BOO_REGISTRATION_FLAG_BY_ERP'], 'string', 'max' => 45],
            [['TST_CREATION_DATE'], 'string', 'max' => 20],
            [['INT_FK_CUSTOMER_ERP_CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCity::className(), 'targetAttribute' => ['INT_FK_CUSTOMER_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']],
            [['INT_FK_ERP_COMPANY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCompany::className(), 'targetAttribute' => ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_CUSTOMER' => 'Código de Cliente no Erp',
            'INT_FK_CUSTOMER_ERP_CITY_ID' => 'cidade',
            'INT_FK_ERP_COMPANY_ID' => 'Código da empresa no Erp',
            'STR_ADDRESS' => 'Endereço',
            'STR_ZIP_CODE' => 'Código postal',
            'STR_DDI_PHONE' => 'DDI  telefone',
            'STR_DDD_PHONE' => 'DDD  telefone',
            'STR_PHONE' => 'telefone',
            'STR_DDI_FAX' => 'DDI  Fax',
            'STR_DDD_FAX' => 'DDD  Fax',
            'STR_FAX' => 'Fax',
            'TST_CREATION_DATE' => 'Data do registro',
            'STR_NOTE' => 'Observções',
            'BOO_STATUS' => 'Status',
            'FLO_DISCOUNT_VALUE' => 'Valor de desconto',
            'FLO_DISCOUNT_PERCENTAGE' => 'Porcentagem de desconto',
            'BOO_REGISTRATION_FLAG_BY_ERP' => 'Registro pelo site ou Erp',
        ];
    }
    public function getErpContact()
    {
        return $this->hasMany(ErpContact::className(), ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getIntFkCustomerErpCity()
    {
        return $this->hasOne(ErpCity::className(), ['INT_PK_ID_ERP_CITY' => 'INT_FK_CUSTOMER_ERP_CITY_ID']);
    }
    public function getErpCompany()
    {
        return $this->hasOne(ErpCompany::className(), ['INT_PK_ID_ERP_COMPANY' => 'INT_FK_ERP_COMPANY_ID']);
    }
    public function getErpCustomerCollection()
    {
        return $this->hasMany(ErpCustomerCollection::className(), ['INT_FK_ID_ERP_CUSTOMER' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getErpCustomerHasErpContact()
    {
        return $this->hasMany(ErpCustomerHasErpContact::className(), ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getErpHistoryLicense()
    {
        return $this->hasMany(ErpHistoryLicense::className(), ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getErpLicense()
    {
        return $this->hasMany(ErpLicense::className(), ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getErpSendLrNFCustomer()
    {
        return $this->hasMany(ErpSendLrNfCustomer::className(), ['ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']);
    }
    public function getErpCustomer()
    {
    	return ArrayHelper::map(
    		ErpCustomer::find()->joinWith('erpCompany')->asArray()->all(),
    		'INT_PK_ID_ERP_CUSTOMER',
   			'erpCompany.STR_SOCIAL_REASON'
    	);
    }
}
