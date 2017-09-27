<?php
namespace app\models;
use Yii;
class ErpContact extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CONTACT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'INT_FK_ERP_CUSTOMER_ID'], 'integer'],
            [['STR_NAME_CONTACT'], 'required'],
            [['STR_NAME_CONTACT', 'STR_LAST_NAME_CONTACT', 'STR_DEPARTAMENT'], 'string', 'max' => 50],
            [['STR_EMAIL'], 'string', 'max' => 100],
            [['STR_DDI_PHONE', 'STR_DDD_PHONE'], 'string', 'max' => 2],
            [['STR_PHONE', 'STR_BRANCH_LINE'], 'string', 'max' => 10],
            [['INT_FK_ERP_CUSTOMER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCustomer::className(), 'targetAttribute' => ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_CONTACT' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Contact'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'INT_FK_ERP_CUSTOMER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Customer  ID'),
            'STR_NAME_CONTACT' => Yii::t('erpModel', 'Str  Name  Contact'),
            'STR_LAST_NAME_CONTACT' => Yii::t('erpModel', 'Str  Last  Name  Contact'),
            'STR_DEPARTAMENT' => Yii::t('erpModel', 'Str  Departament'),
            'STR_EMAIL' => Yii::t('erpModel', 'Str  Email'),
            'STR_DDI_PHONE' => Yii::t('erpModel', 'Str  Ddi  Phone'),
            'STR_DDD_PHONE' => Yii::t('erpModel', 'Str  Ddd  Phone'),
            'STR_PHONE' => Yii::t('erpModel', 'Str  Phone'),
            'STR_BRANCH_LINE' => Yii::t('erpModel', 'Str  Branch  Line'),
        ];
    }
    public function getIntFkErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ERP_CUSTOMER_ID']);
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}
