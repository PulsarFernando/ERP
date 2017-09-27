<?php
namespace app\models;
use Yii;
class ErpLicenseFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_LICENSE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_USER_ID', 'INT_FK_ERP_COMPANY_ID', 'STR_DESCRIPTION', 'STR_SOCIAL_REASON', 'STR_FANTASY_NAME', 'STR_CNPJ', 'STR_INVOICE'], 'required'],
            [['INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_USER_ID', 'INT_FK_ERP_COMPANY_ID', 'BOO_COMPLETED', 'BOO_CLOSED_INVOICE'], 'integer'],
            [['STR_DESCRIPTION'], 'string'],
            [['FLO_TOTAL_AMOUNT'], 'number'],
            [['DAT_CREATION_LICENSE', 'DAT_PAYDAY', 'TST_CREATION_DATE'], 'safe'],
            [['STR_SOCIAL_REASON', 'STR_FANTASY_NAME'], 'string', 'max' => 100],
            [['STR_STATE_REGISTRATION', 'STR_CNPJ'], 'string', 'max' => 20],
            [['STR_INVOICE'], 'string', 'max' => 6],
            [['INT_FK_ERP_CUSTOMER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCustomer::className(), 'targetAttribute' => ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']],
            [['INT_FK_ERP_COMPANY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCompany::className(), 'targetAttribute' => ['INT_FK_ERP_COMPANY_ID' => 'INT_PK_ID_ERP_COMPANY']],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_LICENSE' => Yii::t('erpModel', 'Int  Pk  Id  Erp  License'),
            'INT_FK_ERP_CUSTOMER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Customer  ID'),
            'INT_FK_ERP_USER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  ID'),
            'INT_FK_ERP_COMPANY_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Company  ID'),
            'STR_DESCRIPTION' => Yii::t('erpModel', 'Str  Description'),
            'STR_SOCIAL_REASON' => Yii::t('erpModel', 'Str  Social  Reason'),
            'STR_FANTASY_NAME' => Yii::t('erpModel', 'Str  Fantasy  Name'),
            'STR_STATE_REGISTRATION' => Yii::t('erpModel', 'Str  State  Registration'),
            'STR_CNPJ' => Yii::t('erpModel', 'Str  Cnpj'),
            'FLO_TOTAL_AMOUNT' => Yii::t('erpModel', 'Flo  Total  Amount'),
            'DAT_CREATION_LICENSE' => Yii::t('erpModel', 'Dat  Creation  License'),
            'DAT_PAYDAY' => Yii::t('erpModel', 'Dat  Payday'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'STR_INVOICE' => Yii::t('erpModel', 'Str  Invoice'),
            'BOO_COMPLETED' => Yii::t('erpModel', 'Boo  Completed'),
            'BOO_CLOSED_INVOICE' => Yii::t('erpModel', 'ANTIGA BAIXADA'),
        ];
    }
    public function getIntFkErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ERP_CUSTOMER_ID']);
    }
    public function getIntFkErpCompany()
    {
        return $this->hasOne(ErpCompany::className(), ['INT_PK_ID_ERP_COMPANY' => 'INT_FK_ERP_COMPANY_ID']);
    }
    public function getIntFkErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getErpLicenseFile()
    {
        return $this->hasMany(ErpLicenseFile::className(), ['INT_FK_ERP_LICENSE_ID' => 'INT_PK_ID_ERP_LICENSE']);
    }
}