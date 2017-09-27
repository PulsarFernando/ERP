<?php
namespace app\models;
use Yii;
class SiteCustomerDownloadAlert extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_CUSTOMER_DOWNLOAD_ALERT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID'], 'required'],
            [['INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID', 'INT_DOWNLOAD_PER_MONTH', 'INT_DOWNLOAD_PER_YER', 'INT_DOWNLOAD_PER_DAY'], 'integer'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_CUSTOMER_DOWNLOAD_ALERT' => Yii::t('erpModel', 'Antigo: site_alert_client_downlod'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'INT_FK_ERP_USER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  ID'),
            'INT_DOWNLOAD_PER_MONTH' => Yii::t('erpModel', 'Int  Download  Per  Month'),
            'INT_DOWNLOAD_PER_YER' => Yii::t('erpModel', 'Int  Download  Per  Yer'),
            'INT_DOWNLOAD_PER_DAY' => Yii::t('erpModel', 'Int  Download  Per  Day'),
        ];
    }
    public function getIntFkErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}
