<?php
namespace app\models;
use Yii;
class ErpPrice extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_PRICE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_PROJECT_TYPE_ID', 'INT_FK_ERP_UTILIZATION_ID', 'FLO_AMOUNT'], 'required'],
            [['INT_FK_ERP_PROJECT_TYPE_ID', 'INT_FK_ERP_DESCRIPTION_ID', 'INT_FK_ERP_UTILIZATION_ID', 'INT_FK_ERP_FORMAT_ID', 'INT_FK_ERP_PERIODICITY_ID', 'INT_FK_ERP_DISTRIBUTION_ID', 'BOO_STATUS', 'BOO_CURRENT_PRICE', 'BOO_PICTURE'], 'integer'],
            [['FLO_AMOUNT'], 'number'],
            [['INT_FK_ERP_DESCRIPTION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpDescription::className(), 'targetAttribute' => ['INT_FK_ERP_DESCRIPTION_ID' => 'INT_PK_ID_ERP_DESCRIPTION']],
            [['INT_FK_ERP_FORMAT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpFormat::className(), 'targetAttribute' => ['INT_FK_ERP_FORMAT_ID' => 'INT_PK_ID_ERP_FORMAT']],
            [['INT_FK_ERP_DISTRIBUTION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpDistribution::className(), 'targetAttribute' => ['INT_FK_ERP_DISTRIBUTION_ID' => 'INT_PK_ID_ERP_DISTRIBUTION']],
            [['INT_FK_ERP_PERIODICITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpPeriodicity::className(), 'targetAttribute' => ['INT_FK_ERP_PERIODICITY_ID' => 'INT_PK_ID_ERP_PERIODICITY']],
            [['INT_FK_ERP_UTILIZATION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUtilization::className(), 'targetAttribute' => ['INT_FK_ERP_UTILIZATION_ID' => 'INT_PK_ID_ERP_UTILIZATION']],
            [['INT_FK_ERP_PROJECT_TYPE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpProjectType::className(), 'targetAttribute' => ['INT_FK_ERP_PROJECT_TYPE_ID' => 'INT_PK_ID_PROJECT_TYPE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_PRICE' => Yii::t('erpModel', 'ANTIGA USO'),
            'INT_FK_ERP_PROJECT_TYPE_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Project  Type  ID'),
            'INT_FK_ERP_DESCRIPTION_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Description  ID'),
            'INT_FK_ERP_UTILIZATION_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Utilization  ID'),
            'INT_FK_ERP_FORMAT_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Format  ID'),
            'INT_FK_ERP_PERIODICITY_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Periodicity  ID'),
            'INT_FK_ERP_DISTRIBUTION_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Distribution  ID'),
            'FLO_AMOUNT' => Yii::t('erpModel', 'Flo  Amount'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
            'BOO_CURRENT_PRICE' => Yii::t('erpModel', 'Boo  Current  Price'),
        	'BOO_PICTURE' => 'Tipo do arquivo',
        ];
    }
    public function getErpLicenseFile()
    {
        return $this->hasMany(ErpLicenseFile::className(), ['INT_FK_ERP_PRICE_ID' => 'INT_PK_ID_ERP_PRICE']);
    }
    public function getIntFkErpDescription()
    {
        return $this->hasOne(ErpDescription::className(), ['INT_PK_ID_ERP_DESCRIPTION' => 'INT_FK_ERP_DESCRIPTION_ID']);
    }
    public function getIntFkErpFormat()
    {
        return $this->hasOne(ErpFormat::className(), ['INT_PK_ID_ERP_FORMAT' => 'INT_FK_ERP_FORMAT_ID']);
    }
    public function getIntFkErpDistribution()
    {
        return $this->hasOne(ErpDistribution::className(), ['INT_PK_ID_ERP_DISTRIBUTION' => 'INT_FK_ERP_DISTRIBUTION_ID']);
    }
    public function getIntFkErpPeriodicity()
    {
        return $this->hasOne(ErpPeriodicity::className(), ['INT_PK_ID_ERP_PERIODICITY' => 'INT_FK_ERP_PERIODICITY_ID']);
    }
    public function getIntFkErpUtilization()
    {
        return $this->hasOne(ErpUtilization::className(), ['INT_PK_ID_ERP_UTILIZATION' => 'INT_FK_ERP_UTILIZATION_ID']);
    }
    public function getIntFkErpProjectType()
    {
        return $this->hasOne(ErpProjectType::className(), ['INT_PK_ID_PROJECT_TYPE' => 'INT_FK_ERP_PROJECT_TYPE_ID']);
    }
    public function getSiteDownload()
    {
        return $this->hasMany(SiteDownload::className(), ['INT_FK_ERP_PRICE_ID' => 'INT_PK_ID_ERP_PRICE']);
    }
}