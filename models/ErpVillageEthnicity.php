<?php
namespace app\models;
use Yii;
class ErpVillageEthnicity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_VILLAGE_ETHNICITY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_VILLAGE_ETHNICITY_ID', 'BOO_STATUS'], 'integer'],
            [['STR_NAME', 'STR_SYNONYM'], 'required'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_NAME', 'STR_SYNONYM'], 'string', 'max' => 255],
            [['INT_FK_VILLAGE_ETHNICITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpVillageEthnicity::className(), 'targetAttribute' => ['INT_FK_VILLAGE_ETHNICITY_ID' => 'INT_PK_ID_VILLAGE_ETHNICITY']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_VILLAGE_ETHNICITY' => Yii::t('erpModel', 'ANTIGO: rel_etnia_aldeia'),
            'INT_FK_VILLAGE_ETHNICITY_ID' => Yii::t('erpModel', 'Int  Fk  Village  Ethnicity  ID'),
            'STR_NAME' => Yii::t('erpModel', 'Str  Name'),
            'STR_SYNONYM' => Yii::t('erpModel', 'Str  Synonym'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
        ];
    }
    public function getErpLui()
    {
        return $this->hasMany(ErpLui::className(), ['INT_FK_VILLAGE_ETHNICITY_ID' => 'INT_PK_ID_VILLAGE_ETHNICITY']);
    }
    public function getIntFkErpVillageEthnicity()
    {
        return $this->hasOne(ErpVillageEthnicity::className(), ['INT_PK_ID_VILLAGE_ETHNICITY' => 'INT_FK_VILLAGE_ETHNICITY_ID']);
    }
    public function getErpVillageEthnicity()
    {
        return $this->hasMany(ErpVillageEthnicity::className(), ['INT_FK_VILLAGE_ETHNICITY_ID' => 'INT_PK_ID_VILLAGE_ETHNICITY']);
    }
}