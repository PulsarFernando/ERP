<?php
namespace app\models;
use Yii;
class ErpBank extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_BANK';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_BANK_CODE'], 'required'],
            [['INT_BANK_CODE'], 'string', 'max' => 3],
            [['STR_BANK_NAME'], 'string', 'max' => 100],
            [['STR_URL_BANK'], 'string', 'max' => 150],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_BANK' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Bank'),
            'INT_BANK_CODE' => Yii::t('erpModel', 'Int  Bank  Code'),
            'STR_BANK_NAME' => Yii::t('erpModel', 'Str  Bank  Name'),
            'STR_URL_BANK' => Yii::t('erpModel', 'Str  Url  Bank'),
        ];
    }
    public function getErpAuthor()
    {
        return $this->hasMany(ErpAuthor::className(), ['INT_FK_ERP_BANK_ID' => 'INT_PK_ID_ERP_BANK']);
    }
    public function getErpCustomerCollection()
    {
        return $this->hasMany(ErpCustomerCollection::className(), ['INT_FK_ERP_BANK_ID' => 'INT_PK_ID_ERP_BANK']);
    }
}