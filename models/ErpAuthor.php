<?php
namespace app\models;
use Yii;
class ErpAuthor extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_AUTHOR';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_AUTHOR', 'INT_FK_ERP_CITY_ID', 'STR_NAME_AUTHOR', 'STR_FULL_NAME_AUTHOR', 'STR_CPF', 'STR_PASSWORD'], 'required'],
            [['INT_PK_ID_SITE_AUTHOR', 'INT_FK_ERP_CITY_ID', 'INT_FK_ERP_COMPANY_ID', 'INT_FK_ERP_BANK_ID', 'BOO_ERP_STATUS', 'BOO_PULSAR_STATUS'], 'integer'],
            [['STR_NOTE'], 'string'],
            [['STR_NAME_AUTHOR'], 'string', 'max' => 60],
            [['STR_FULL_NAME_AUTHOR', 'STR_ADDRESS', 'STR_EMAIL_ONE', 'STR_EMAIL_TWO', 'STR_EMAIL_THREE', 'STR_DISTRICT'], 'string', 'max' => 100],
            [['STR_AUTHOR_ACRONYM'], 'string', 'max' => 3],
            [['STR_CPF'], 'string', 'max' => 11],
            [['STR_CNPJ'], 'string', 'max' => 14],
            [['STR_RG', 'STR_ACCOUNT'], 'string', 'max' => 15],
            [['STR_ZIP_CODE'], 'string', 'max' => 8],
            [['STR_DDI_PHONE', 'STR_DDD_PHONE', 'STR_DDI_MOBILE', 'STR_BANK_OFFICE_DIGIT'], 'string', 'max' => 2],
            [['STR_PHONE', 'STR_MOBILE'], 'string', 'max' => 10],
            [['STR_DDD_MOBILE'], 'string', 'max' => 45],
            [['STR_BANK_OFFICE_CODE'], 'string', 'max' => 4],
            [['STR_PASSWORD'], 'string', 'max' => 16],
            [['INT_PK_ID_SITE_AUTHOR'], 'unique'],
            [['INT_FK_ERP_BANK_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpBank::className(), 'targetAttribute' => ['INT_FK_ERP_BANK_ID' => 'INT_PK_ID_ERP_BANK']],
            [['INT_FK_ERP_CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCity::className(), 'targetAttribute' => ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']],
            [['INT_FK_ERP_COMPANY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCompany::className(), 'targetAttribute' => ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_AUTHOR' => Yii::t('erpModel', 'id (união entreAUTORES_OFC e fotografos)'),
            'INT_PK_ID_ERP_AUTHOR' => Yii::t('erpModel', 'ANTIGO: (pulsar.fotografos e sig.AUTORES_OFC)'),
            'INT_FK_ERP_CITY_ID' => Yii::t('erpModel', 'Código da cidade'),
            'INT_FK_ERP_COMPANY_ID' => Yii::t('erpModel', 'Código da empresa'),
            'INT_FK_ERP_BANK_ID' => Yii::t('erpModel', 'Código do banco'),
            'STR_NAME_AUTHOR' => Yii::t('erpModel', 'Nome do autor'),
            'STR_FULL_NAME_AUTHOR' => Yii::t('erpModel', 'Nome completo do autor'),
            'STR_AUTHOR_ACRONYM' => Yii::t('erpModel', 'Sigla do autor'),
            'STR_CPF' => Yii::t('erpModel', 'Str  CPF'),
            'STR_CNPJ' => Yii::t('erpModel', 'Str  CNPJ'),
            'STR_RG' => Yii::t('erpModel', 'Str  RG'),
            'STR_ADDRESS' => Yii::t('erpModel', 'Endereço'),
            'STR_ZIP_CODE' => Yii::t('erpModel', 'C.E.P'),
            'STR_DDI_PHONE' => Yii::t('erpModel', 'DDI'),
            'STR_DDD_PHONE' => Yii::t('erpModel', 'DDD'),
            'STR_PHONE' => Yii::t('erpModel', 'Telefone'),
            'STR_DDI_MOBILE' => Yii::t('erpModel', 'DDI (celular)'),
            'STR_DDD_MOBILE' => Yii::t('erpModel', 'DDD (celular)'),
            'STR_MOBILE' => Yii::t('erpModel', 'Telefone celular'),
            'STR_EMAIL_ONE' => Yii::t('erpModel', 'E-mail'),
            'STR_EMAIL_TWO' => Yii::t('erpModel', 'Segundo e-mail'),
            'STR_EMAIL_THREE' => Yii::t('erpModel', 'Terceiro e-mail'),
            'STR_NOTE' => Yii::t('erpModel', 'Observação'),
            'STR_BANK_OFFICE_CODE' => Yii::t('erpModel', 'Agência bancária'),
            'STR_BANK_OFFICE_DIGIT' => Yii::t('erpModel', 'Digito da agência'),
            'STR_ACCOUNT' => Yii::t('erpModel', 'Conta bancária'),
            'STR_DISTRICT' => Yii::t('erpModel', 'Bairro'),
            'STR_PASSWORD' => Yii::t('erpModel', 'Senha'),
            'BOO_ERP_STATUS' => Yii::t('erpModel', 'Erp Status'),
            'BOO_PULSAR_STATUS' => Yii::t('erpModel', 'Pulsar Status'),
        ];
    }
    public function getIntFkErpBank()
    {
        return $this->hasOne(ErpBank::className(), ['INT_PK_ID_ERP_BANK' => 'INT_FK_ERP_BANK_ID']);
    }
    public function getIntFkErpCity()
    {
        return $this->hasOne(ErpCity::className(), ['INT_PK_ID_ERP_CITY' => 'INT_FK_ERP_CITY_ID']);
    }
    public function getIntFkErpCompany()
    {
        return $this->hasOne(ErpCompany::className(), ['INT_PK_ID_ERP_COMPANY' => 'INT_FK_ERP_COMPANY_ID']);
    }
    public function getErpAuthorHasHomePageFile()
    {
        return $this->hasMany(ErpAuthorHasHomePageFile::className(), ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
    public function getIntFkSiteHomePageFile()
    {
        return $this->hasMany(SiteHomePageFile::className(), ['INT_PK_ID_SITE_HOMEPAGE_FILE' => 'INT_FK_SITE_HOMEPAGE_FILE_ID'])->viaTable('ERP_AUTHOR_HAS_HOMEPAGE_FILE', ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
    public function getErpLui()
    {
        return $this->hasMany(ErpLui::className(), ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
    public function getSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_FK_ERP_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
    public function getSiteHomePageFile()
    {
        return $this->hasMany(SiteHomePageFile::className(), ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
    public function getSiteRelationFileCodeAndOriginalFile()
    {
        return $this->hasMany(SiteRelationFileCodeAndOriginalFile::className(), ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']);
    }
}