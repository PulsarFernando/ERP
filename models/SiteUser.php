<?php
namespace app\models;
use Yii;
class SiteUser extends \yii\db\ActiveRecord
{
	const SCENARIO_TEMPORARY_CUSTOMER = 'temporaryCustomer';
	const SCENARIO_CUSTOMER = 'customer';
	const SCENARIO_UPDATE_CUSTOMER_COMPANY = 'updateCustomerCompany';
    public static function tableName()
    {
        return 'SITE_USER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function scenarios()
    {
    	$arrScenario = parent::scenarios();
    	$arrScenario[self::SCENARIO_CUSTOMER] = ['INT_PK_ID_SITE_USER', 'INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_COMPANY_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID', 'STR_LOGIN', 'STR_PASSWORD', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER', 'BOO_SPECIAL_USER_ADMINISTRATOR', 'BOO_STATUS', 'TST_CREATION_DATE', 'TST_LAST_ACESS', 'STR_ADDRESS' , 'STR_ZIP_CODE', 'STR_NUMBER', 'STR_ADDRESS_COMPLEMENT', 'STR_CPF', 'STR_NAME', 'STR_EMAIL'];	
    	$arrScenario[	self::SCENARIO_TEMPORARY_CUSTOMER] = ['STR_LOGIN', 'STR_NAME', 'STR_PASSWORD', 'STR_EMAIL', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER', 'BOO_STATUS', 'TST_CREATION_DATE'];	
    	$arrScenario[self::SCENARIO_UPDATE_CUSTOMER_COMPANY] = ['INT_PK_ID_SITE_USER', 'INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_COMPANY_ID'];
    	return $arrScenario;		
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_COMPANY_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER', 'BOO_STATUS'], 'integer'],
        	[['INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'STR_LOGIN', 'STR_PASSWORD', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER_ADMINISTRATOR', 'BOO_STATUS', 'TST_CREATION_DATE', 'TST_LAST_ACESS', 'STR_NAME', 'STR_EMAIL'], 'required', 'on' => self::SCENARIO_CUSTOMER],
        	[['INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'STR_LOGIN', 'STR_PASSWORD', 'STR_NAME', 'STR_EMAIL'], 'required'],
            [['TST_CREATION_DATE', 'TST_LAST_ACESS'], 'safe'],
            [['STR_LOGIN', 'BOO_SPECIAL_USER_ADMINISTRATOR'], 'string', 'max' => 45],
            [['STR_PASSWORD'], 'string', 'max' => 16],
            [['STR_ADDRESS', 'STR_NAME', 'STR_EMAIL'], 'string', 'max' => 100],
        	[['STR_EMAIL'],'email'],	
            [['STR_ZIP_CODE'], 'string', 'max' => 8],
            [['STR_NUMBER'], 'string', 'max' => 5],
            [['STR_ADDRESS_COMPLEMENT'], 'string', 'max' => 50],
            [['STR_CPF'], 'string', 'max' => 11],
            [['INT_FK_ERP_CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCity::className(), 'targetAttribute' => ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']],
            [['INT_FK_ERP_COMPANY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCompany::className(), 'targetAttribute' => ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']],
            [['INT_FK_ERP_CUSTOMER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCustomer::className(), 'targetAttribute' => ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']],
            [['INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserDownloadPermission::className(), 'targetAttribute' => ['INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => 'INT_PK_ID_SITE_USER_DOWNLOAD_PERMISSION']],
            [['INT_FK_SITE_USER_LANGUAGE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserLanguage::className(), 'targetAttribute' => ['INT_FK_SITE_USER_LANGUAGE_ID' => 'INT_PK_ID_SITE_USER_LANGUAGE']],
            [['INT_FK_SITE_TYPE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserType::className(), 'targetAttribute' => ['INT_FK_SITE_TYPE_USER_ID' => 'INT_PK_ID_TYPE_USER']],
            [['INT_FK_SITE_USER_TYPE_NEWSLETTER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserTypeNewsletter::className(), 'targetAttribute' => ['INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => 'INT_PK_ID_SITE_USER_TYPE_NEWSLETTER']],
        	[['INT_FK_SITE_SPECIAL_USER_PREFIX_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteSpecialUserPrefix::className(), 'targetAttribute' => ['INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => 'INT_PK_ID_SITE_SPECIAL_USER_PREFIX']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_USER' => 'Código de cliente',
            'INT_FK_ERP_CUSTOMER_ID' => 'Cliente ERP',
            'INT_FK_ERP_COMPANY_ID' => 'Empresa',
            'INT_FK_ERP_CITY_ID' => 'Cidade',
            'INT_FK_SITE_TYPE_USER_ID' => 'Tipo de cliente',
            'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => 'Permissão de download',
            'INT_FK_SITE_USER_LANGUAGE_ID' => 'Idioma',
            'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => 'Tipo de newsletter',
            'INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => 'Prefixo de cliente especial',
            'STR_LOGIN' => 'Login',
            'STR_PASSWORD' => 'Senha',
            'BOO_TEMPORARY_USER' => 'Cliente temporário',
            'INT_DOWNLOAD_LIMIT' => 'Limite de download',
            'BOO_NEWSLETTER' => 'Newsletter',
            'BOO_ACCEPT_TERM' => 'Termos e condições',
            'INT_PAGINATION' => 'Paginação',
            'BOO_SPECIAL_USER' => 'Cliente especial',
            'BOO_SPECIAL_USER_ADMINISTRATOR' => 'Administrador de c.e.',
            'BOO_STATUS' => 'Status',
            'TST_CREATION_DATE' => 'Data de cadastro',
            'TST_LAST_ACESS' => 'último acesso',
            'STR_ADDRESS' => 'Endereço',
            'STR_ZIP_CODE' => 'Codigo postal',
            'STR_NUMBER' => 'Número',
            'STR_ADDRESS_COMPLEMENT' => 'Complemento',
            'STR_CPF' => 'CPF',
        	'STR_NAME' => 'Nome', 
        	'STR_EMAIL' => 'Email', 
        ];
    }
    public function getErpContacts()
    {
        return $this->hasMany(ErpContact::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteCustomerDownloadAlert()
    {
        return $this->hasMany(SiteCustomerDownloadAlert::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteDownload()
    {
        return $this->hasMany(SiteDownload::className(), ['INT_FK_ID_SITE_USER' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteDownloadLayout()
    {
        return $this->hasMany(SiteDownloadLayout::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteFtpFile()
    {
        return $this->hasMany(SiteFtpFile::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteLogReportDownload()
    {
        return $this->hasMany(SiteLogReportDownload::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteQuotationCollection()
    {
        return $this->hasMany(SiteQuotationCollection::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteQuoteSent()
    {
        return $this->hasMany(SiteQuoteSent::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteSendEmailFile()
    {
        return $this->hasMany(SiteSendEmailFile::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteSpecialUserTitle()
    {
        return $this->hasMany(SiteSpecialUserTitle::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getErpCity()
    {
        return $this->hasOne(ErpCity::className(), ['INT_PK_ID_ERP_CITY' => 'INT_FK_ERP_CITY_ID']);
    }
    public function getErpCompany()
    {
        return $this->hasOne(ErpCompany::className(), ['INT_PK_ID_ERP_COMPANY' => 'INT_FK_ERP_COMPANY_ID']);
    }
    public function getErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ERP_CUSTOMER_ID']);
    }
    public function getSiteUserDownloadPermission()
    {
        return $this->hasOne(SiteUserDownloadPermission::className(), ['INT_PK_ID_SITE_USER_DOWNLOAD_PERMISSION' => 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID']);
    }
    public function getSiteUserLanguage()
    {
        return $this->hasOne(SiteUserLanguage::className(), ['INT_PK_ID_SITE_USER_LANGUAGE' => 'INT_FK_SITE_USER_LANGUAGE_ID']);
    }
    public function getSiteUserType()
    {
        return $this->hasOne(SiteUserType::className(), ['INT_PK_ID_TYPE_USER' => 'INT_FK_SITE_TYPE_USER_ID']);
    }
    public function getSiteUserTypeNewsletter()
    {
        return $this->hasOne(SiteUserTypeNewsletter::className(), ['INT_PK_ID_SITE_USER_TYPE_NEWSLETTER' => 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID']);
    }
    public function getSiteUserFolder()
    {
        return $this->hasMany(SiteUserFolder::className(), ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteUserPromotion()
    {
        return $this->hasOne(SiteUserPromotion::className(), ['INT_FK_ID_SITE_USER' => 'INT_PK_ID_SITE_USER']);
    }
    public function getSiteSpecialUserPrefix()
    {
    	return $this->hasOne(SiteSpecialUserPrefix::className(), ['INT_PK_ID_SITE_SPECIAL_USER_PREFIX' => 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID']);
    }
    
}