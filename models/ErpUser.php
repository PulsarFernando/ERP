<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class ErpUser extends ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_USER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_ROLE_ID', 'STR_USER_NAME', 'STR_LOGIN', 'STR_PASSWORD', 'STR_EMAIL'], 'required'],
            [['INT_FK_ERP_ROLE_ID', 'BOO_ERP_USER_STATUS'], 'integer'],
            [['STR_USER_NAME'], 'string', 'max' => 60],
            [['STR_LOGIN'], 'string', 'max' => 10],
            [['STR_PASSWORD'], 'string', 'max' => 12],
        	[['STR_EMAIL'], 'email'],
            [['STR_EMAIL'], 'string', 'max' => 45],
            [['INT_FK_ERP_ROLE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpRole::className(), 'targetAttribute' => ['INT_FK_ERP_ROLE_ID' => 'INT_PK_ID_ERP_ROLE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_USER' => 'Código do colaborador',
            'INT_FK_ERP_ROLE_ID' => 'Código da função',
            'STR_USER_NAME' => 'Nome do colaborador',
            'STR_LOGIN' => 'Login',
            'STR_PASSWORD' => 'Password',
            'BOO_ERP_USER_STATUS' => 'Status',
            'STR_EMAIL' => 'E-mail',
        ];
    }
    public function getErpLicense()
    {
        return $this->hasMany(ErpLicense::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getErpLoginindexer()
    {
        return $this->hasMany(ErpLoginindexer::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getIntFkErpRole()
    {
        return $this->hasOne(ErpRole::className(), ['INT_PK_ID_ERP_ROLE' => 'INT_FK_ERP_ROLE_ID']);
    }
    public function getErpRole()
    {
    	return $this->hasOne(ErpRole::className(), ['INT_PK_ID_ERP_ROLE' => 'INT_FK_ERP_ROLE_ID']);
    }
    public function getErpUserRunway()
    {
        return $this->hasMany(ErpUserRunway::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getSiteAmountIndexer()
    {
        return $this->hasOne(SiteAmountIndexer::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getSiteCustomerDownloadAlert()
    {
        return $this->hasMany(SiteCustomerDownloadAlert::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getSiteFtpFile()
    {
        return $this->hasMany(SiteFtpFile::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }
    public function getSiteQuoteSent()
    {
        return $this->hasMany(SiteQuoteSent::className(), ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']);
    }  
}