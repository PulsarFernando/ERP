<?php
namespace app\models;
use Yii;
class ErpCustomerHasErpContact extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CUSTOMER_HAS_ERP_CONTRACT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_CUSTOMER_ID', 'INT_PK_ERP_CONTRACT_ID'], 'required'],
            [['INT_FK_ERP_CUSTOMER_ID', 'INT_PK_ERP_CONTRACT_ID'], 'integer'],
            [['INT_PK_ERP_CONTRACT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpContract::className(), 'targetAttribute' => ['INT_PK_ERP_CONTRACT_ID' => 'INT_PK_ID_ERP_CONTRACT']],
            [['INT_FK_ERP_CUSTOMER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCustomer::className(), 'targetAttribute' => ['INT_FK_ERP_CUSTOMER_ID' => 'INT_PK_ID_ERP_CUSTOMER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ERP_CUSTOMER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Customer  ID'),
            'INT_PK_ERP_CONTRACT_ID' => Yii::t('erpModel', 'Int  Pk  Erp  Contract  ID'),
        ];
    }
    public function getIntFkErpContract()
    {
        return $this->hasOne(ErpContract::className(), ['INT_PK_ID_ERP_CONTRACT' => 'INT_PK_ERP_CONTRACT_ID']);
    }
    public function getIntFkErpCustomer()
    {
        return $this->hasOne(ErpCustomer::className(), ['INT_PK_ID_ERP_CUSTOMER' => 'INT_FK_ERP_CUSTOMER_ID']);
    }
}