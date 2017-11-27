<?php
namespace app\models;
use Yii;
class ErpLicense extends \yii\db\ActiveRecord
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
            'INT_PK_ID_ERP_LICENSE' => 'Código da LR',
            'INT_FK_ERP_CUSTOMER_ID' => 'Código cliente oficial',
            'INT_FK_ERP_USER_ID' => 'Código cliente',
            'INT_FK_ERP_COMPANY_ID' => 'Código da empresa',
            'STR_DESCRIPTION' => 'Descrição',
            'STR_SOCIAL_REASON' => 'Razão social',
            'STR_FANTASY_NAME' => 'Nome fantasia',
            'STR_STATE_REGISTRATION' => 'Inscrição estadual',
            'STR_CNPJ' => 'CNPJ',
            'FLO_TOTAL_AMOUNT' => 'Total',
            'DAT_CREATION_LICENSE' => 'Data da LR',
            'DAT_PAYDAY' => 'Data do pageamento',
            'TST_CREATION_DATE' => 'Data do registro',
            'STR_INVOICE' => 'Nota fiscal',
            'BOO_COMPLETED' => 'Finalizado',
            'BOO_CLOSED_INVOICE' => 'Faturado',
        ];
    }
    public function getErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ERP_CUSTOMER_ID']);
    }
    public function getErpCompany()
    {
        return $this->hasOne(ErpCompany::className(), ['INT_PK_ID_ERP_COMPANY' => 'INT_FK_ERP_COMPANY_ID']);
    }
    public function getErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getErpLicenseFile()
    {
        return $this->hasMany(ErpLicenseFile::className(), ['INT_FK_ERP_LICENSE_ID' => 'INT_PK_ID_ERP_LICENSE']);
    }
}
