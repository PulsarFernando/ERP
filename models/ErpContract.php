<?php
namespace app\models;
use Yii;
class ErpContract extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_CONTRACT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['FK_ERP_TYPE_FILE_ID', 'BOO_DEFAULT', 'BOO_SIGNATURE', 'BOO_INDIAN', 'BOO_STATUS'], 'integer'],
            [['STR_TITTLE'], 'required'],
            [['STR_DESCRIPTION'], 'string'],
            [['STR_TITTLE'], 'string', 'max' => 255],
            [['FK_ERP_TYPE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpTypeFile::className(), 'targetAttribute' => ['FK_ERP_TYPE_FILE_ID' => 'INT_PK_ID_ERP_TYPE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_CONTRACT' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Contract'),
            'FK_ERP_TYPE_FILE_ID' => Yii::t('erpModel', 'Fk  Erp  Type  File  ID'),
            'STR_TITTLE' => Yii::t('erpModel', 'Str  Tittle'),
            'STR_DESCRIPTION' => Yii::t('erpModel', 'Str  Description'),
            'BOO_DEFAULT' => Yii::t('erpModel', 'Boo  Default'),
            'BOO_SIGNATURE' => Yii::t('erpModel', 'Boo  Signature'),
            'BOO_INDIAN' => Yii::t('erpModel', 'Boo  Indian'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
        ];
    }
    public function getIntFkErpTypeFile()
    {
        return $this->hasOne(ErpTypeFile::className(), ['INT_PK_ID_ERP_TYPE_FILE' => 'FK_ERP_TYPE_FILE_ID']);
    }
    public function getErpCustomerHasErpContact()
    {
        return $this->hasMany(ErpCustomerHasErpContact::className(), ['INT_PK_ERP_CONTRACT_ID' => 'INT_PK_ID_ERP_CONTRACT']);
    }
}