<?php
namespace app\models;
use Yii;
class ErpSendLrNfCustomer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_SEND_LR_NF_CUSTOMER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER'], 'required'],
            [['ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER', 'INT_START_DAY_LR', 'INT_END_DAY_LR', 'INT_START_DAY_NF', 'INT_END_DAY_NF', 'INT_DAY_AFTER_NF_EXPIRATION'], 'integer'],
            [['ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER'], 'exist', 'skipOnError' => true, 'targetClass' => ERPCUSTOMER::className(), 'targetAttribute' => ['ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER' => 'INT_PK_ID_ERP_CUSTOMER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SEND_LR_NF_CUSTOMER' => Yii::t('erpModel', 'Int  Pk  Id  Send  Lr  Nf  Customer'),
            'ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER' => Yii::t('erpModel', 'Erp  Customer  Int  Pk  Id  Erp  Customer'),
            'INT_START_DAY_LR' => Yii::t('erpModel', 'Int  Start  Day  Lr'),
            'INT_END_DAY_LR' => Yii::t('erpModel', 'Int  End  Day  Lr'),
            'INT_START_DAY_NF' => Yii::t('erpModel', 'Int  Start  Day  Nf'),
            'INT_END_DAY_NF' => Yii::t('erpModel', 'Int  End  Day  Nf'),
            'INT_DAY_AFTER_NF_EXPIRATION' => Yii::t('erpModel', 'Int  Day  After  Nf  Expiration'),
        ];
    }
    public function getERPCUSTOMER()
    {
        return $this->hasOne(ERPCUSTOMER::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'ERP_CUSTOMER_INT_PK_ID_ERP_CUSTOMER']);
    }
}