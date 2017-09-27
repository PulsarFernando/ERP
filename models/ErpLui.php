<?php
namespace app\models;
use Yii;
class ErpLui extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_LUI';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_LUI', 'INT_FK_SITE_AUTHOR_ID', 'STR_FILE_NAME', 'STR_AUTHORIZED_BY'], 'required'],
            [['INT_PK_ID_ERP_LUI', 'INT_FK_VILLAGE_ETHNICITY_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_AUTHOR_ID', 'BOO_INDIAN'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_DESCRIPTION'], 'string', 'max' => 255],
            [['STR_FILE_NAME', 'STR_AUTHORIZED_BY'], 'string', 'max' => 100],
            [['STR_MONTH_YEAR'], 'string', 'max' => 7],
            [['INT_PK_ID_ERP_LUI'], 'unique'],
            [['INT_FK_SITE_AUTHOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpAuthor::className(), 'targetAttribute' => ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']],
            [['INT_FK_ERP_CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCity::className(), 'targetAttribute' => ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']],
            [['INT_FK_VILLAGE_ETHNICITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpVillageEthnicity::className(), 'targetAttribute' => ['INT_FK_VILLAGE_ETHNICITY_ID' => 'INT_PK_ID_VILLAGE_ETHNICITY']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_LUI' => Yii::t('erpModel', 'ANTIGA: autorizacao_imagem'),
            'INT_FK_VILLAGE_ETHNICITY_ID' => Yii::t('erpModel', 'Int  Fk  Village  Ethnicity  ID'),
            'INT_FK_ERP_CITY_ID' => Yii::t('erpModel', 'Int  Fk  Erp  City  ID'),
            'INT_FK_SITE_AUTHOR_ID' => Yii::t('erpModel', 'Int  Fk  Site  Author  ID'),
            'STR_DESCRIPTION' => Yii::t('erpModel', 'Str  Description'),
            'STR_FILE_NAME' => Yii::t('erpModel', 'Str  File  Name'),
            'STR_AUTHORIZED_BY' => Yii::t('erpModel', 'Str  Authorized  By'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'BOO_INDIAN' => Yii::t('erpModel', 'Boo  Indian'),
            'STR_MONTH_YEAR' => Yii::t('erpModel', 'Str  Month  Year'),
        ];
    }
    public function getIntFkSiteAuthor()
    {
        return $this->hasOne(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_SITE_AUTHOR_ID']);
    }
    public function getIntFkrpCity()
    {
        return $this->hasOne(ErpCity::className(), ['INT_PK_ID_ERP_CITY' => 'INT_FK_ERP_CITY_ID']);
    }
    public function getIntFkrpVillageEthnicity()
    {
        return $this->hasOne(ErpVillageEthnicity::className(), ['INT_PK_ID_VILLAGE_ETHNICITY' => 'INT_FK_VILLAGE_ETHNICITY_ID']);
    }
    public function getErpLuiHasSiteFile()
    {
        return $this->hasMany(ErpLuiHasSiteFile::className(), ['INT_FK_ID_ERP_LUI' => 'INT_PK_ID_ERP_LUI']);
    }
}