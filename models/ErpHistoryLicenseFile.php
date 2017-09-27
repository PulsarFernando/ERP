<?php
namespace app\models;
use Yii;
class ErpHistoryLicenseFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_HISTORY_LICENSE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_HISTORY_LICENSE_ID', 'INT_FK_ERP_PRICE_ID', 'STR_FILE_CODE', 'STR_SUBJECT', 'STR_AUTHOR', 'STR_AUTHOR_ACRONYM'], 'required'],
            [['INT_FK_ERP_HISTORY_LICENSE_ID', 'INT_FK_ERP_PRICE_ID', 'BOO_FINISHED', 'BOO_REUSE'], 'integer'],
            [['FLO_AMOUNT_FILE', 'FLO_DISCOUNT', 'FLO_AMOUNT_FINAL'], 'number'],
            [['STR_FILE_CODE'], 'string', 'max' => 10],
            [['STR_SUBJECT'], 'string', 'max' => 150],
            [['STR_AUTHOR'], 'string', 'max' => 50],
            [['STR_AUTHOR_ACRONYM'], 'string', 'max' => 3],
            [['INT_FK_ERP_HISTORY_LICENSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpHistoryLicense::className(), 'targetAttribute' => ['INT_FK_ERP_HISTORY_LICENSE_ID' => 'INT_PK_ID_ERP_HISTORY_LICENSE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_LICENSE_FILE' => Yii::t('erpModel', 'LICENSE'),
            'INT_FK_ERP_HISTORY_LICENSE_ID' => Yii::t('erpModel', 'Int  Fk  Erp  History  License  ID'),
            'INT_FK_ERP_PRICE_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Price  ID'),
            'STR_FILE_CODE' => Yii::t('erpModel', 'Str  File  Code'),
            'STR_SUBJECT' => Yii::t('erpModel', 'Str  Subject'),
            'STR_AUTHOR' => Yii::t('erpModel', 'Str  Author'),
            'STR_AUTHOR_ACRONYM' => Yii::t('erpModel', 'Str  Author  Acronym'),
            'FLO_AMOUNT_FILE' => Yii::t('erpModel', 'Flo  Amount  File'),
            'FLO_DISCOUNT' => Yii::t('erpModel', 'Flo  Discount'),
            'FLO_AMOUNT_FINAL' => Yii::t('erpModel', 'Flo  Amount  Final'),
            'BOO_FINISHED' => Yii::t('erpModel', 'Boo  Finished'),
            'BOO_REUSE' => Yii::t('erpModel', 'Boo  Reuse'),
        ];
    }
    public function getIntFkErpHistoryLicense()
    {
        return $this->hasOne(ErpHistoryLicense::className(), ['INT_PK_ID_ERP_HISTORY_LICENSE' => 'INT_FK_ERP_HISTORY_LICENSE_ID']);
    }
}