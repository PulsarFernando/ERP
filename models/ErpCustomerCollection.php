<?php
namespace app\models;
use Yii;
class ErpCustomerCollection extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CUSTOMER_COLLECTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_CUSTOMER_COLLECTION', 'INT_FK_ID_ERP_CUSTOMER', 'INT_FK_ERP_BANK_ID'], 'required'],
            [['INT_PK_ID_CUSTOMER_COLLECTION', 'INT_FK_ID_ERP_CUSTOMER', 'BOO_BANK_SLIP', 'INT_FK_ERP_BANK_ID'], 'integer'],
            [['INT_PK_ID_CUSTOMER_COLLECTION'], 'unique'],
            [['INT_FK_ERP_BANK_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpBank::className(), 'targetAttribute' => ['INT_FK_ERP_BANK_ID' => 'INT_PK_ID_ERP_BANK']],
            [['INT_FK_ID_ERP_CUSTOMER'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCustomer::className(), 'targetAttribute' => ['INT_FK_ID_ERP_CUSTOMER' => 'INT_PK_ID_ERP_CUSTOMER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_CUSTOMER_COLLECTION' => Yii::t('erpModel', 'Int  Pk  Id  Customer  Collection'),
            'INT_FK_ID_ERP_CUSTOMER' => Yii::t('erpModel', 'Int  Fk  Id  Erp  Customer'),
            'BOO_BANK_SLIP' => Yii::t('erpModel', 'Boo  Bank  Slip'),
            'INT_FK_ERP_BANK_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Bank  ID'),
        ];
    }
    public function getIntFkErpBank()
    {
        return $this->hasOne(ErpBank::className(), ['INT_PK_ID_ERP_BANK' => 'INT_FK_ERP_BANK_ID']);
    }
    public function getIntFkIDErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ID_ERP_CUSTOMER']);
    }
}