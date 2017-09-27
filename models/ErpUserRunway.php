<?php
namespace app\models;
use Yii;
class ErpUserRunway extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_USER_RUNWAY';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_USER_ID', 'STR_RUNWAY'], 'required'],
            [['INT_FK_ERP_USER_ID'], 'integer'],
            [['STR_RUNWAY'], 'string'],
            [['TST_CREATION_DATE'], 'safe'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_USER_RUNWAY' => Yii::t('erpModel', 'Int  Pk  Id  Erp  User  Runway'),
            'INT_FK_ERP_USER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  ID'),
            'STR_RUNWAY' => Yii::t('erpModel', 'Str  Runway'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
        ];
    }
    public function getIntFkErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getErpUserRunwayHaserpMenu()
    {
        return $this->hasMany(ErpUserRunwayHasErpMenu::className(), ['INT_FK_ERP_USER_RUNWAY_ID' => 'INT_PK_ID_ERP_USER_RUNWAY']);
    }
    public function getIntFkErpMenu()
    {
        return $this->hasMany(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU_ID'])->viaTable('ERP_USER_RUNWAY_HAS_ERP_MENU', ['INT_FK_ERP_USER_RUNWAY_ID' => 'INT_PK_ID_ERP_USER_RUNWAY']);
    }
}