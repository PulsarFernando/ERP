<?php
namespace app\models;
use Yii;
class ErpLicenseFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_LICENSE_FILE';
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_LICENSE_ID', 'INT_FK_ERP_PRICE_ID', 'STR_FILE_CODE', 'STR_SUBJECT', 'STR_AUTHOR', 'STR_AUTHOR_ACRONYM'], 'required'],
            [['INT_FK_ERP_LICENSE_ID', 'INT_FK_ERP_PRICE_ID', 'BOO_FINISHED', 'BOO_REUSE'], 'integer'],
            [['FLO_AMOUNT_FILE', 'FLO_DISCOUNT', 'FLO_AMOUNT_FINAL'], 'number'],
            [['STR_FILE_CODE'], 'string', 'max' => 10],
            [['STR_SUBJECT'], 'string', 'max' => 150],
            [['STR_AUTHOR'], 'string', 'max' => 50],
            [['STR_AUTHOR_ACRONYM'], 'string', 'max' => 3],
            [['INT_FK_ERP_LICENSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ERPLICENSE::className(), 'targetAttribute' => ['INT_FK_ERP_LICENSE_ID' => 'INT_PK_ID_ERP_LICENSE']],
            [['INT_FK_ERP_PRICE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ERPPRICE::className(), 'targetAttribute' => ['INT_FK_ERP_PRICE_ID' => 'INT_PK_ID_ERP_PRICE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_LICENSE_FILE' => 'Código da LR do arquivo',
            'INT_FK_ERP_LICENSE_ID' => 'Código da LR',
            'INT_FK_ERP_PRICE_ID' => 'Código do preço',
            'STR_FILE_CODE' => 'Código do arquivo',
            'STR_SUBJECT' => 'Assunto',
            'STR_AUTHOR' => 'Autor',
            'STR_AUTHOR_ACRONYM' => 'Sigla do autor',
            'FLO_AMOUNT_FILE' => 'Valor bruto',
            'FLO_DISCOUNT' => 'Desconto',
            'FLO_AMOUNT_FINAL' => 'Valor  Final',
            'BOO_FINISHED' => 'Finalizado',
            'BOO_REUSE' => 'Reuso',
        ];
    }
    public function getErpLicense()
    {
        return $this->hasOne(ErpLicense::className(), ['INT_PK_ID_ERP_LICENSE' => 'INT_FK_ERP_LICENSE_ID']);
    }
    public function getErpPrice()
    {
        return $this->hasOne(ErpPrice::className(), ['INT_PK_ID_ERP_PRICE' => 'INT_FK_ERP_PRICE_ID']);
    }
}