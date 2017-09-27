<?php
namespace app\models;
use Yii;
class ErpUserRunwayHasErpMenu extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_USER_RUNWAY_HAS_ERP_MENU';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_MENU_ID'], 'required'],
            [['INT_FK_ERP_MENU_ID'], 'integer'],
            [['INT_FK_ERP_USER_RUNWAY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUserRunway::className(), 'targetAttribute' => ['INT_FK_ERP_USER_RUNWAY_ID' => 'INT_PK_ID_ERP_USER_RUNWAY']],
            [['INT_FK_ERP_MENU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpMenu::className(), 'targetAttribute' => ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ERP_USER_RUNWAY_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  Runway  ID'),
            'INT_FK_ERP_MENU_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Menu  ID'),
        ];
    }
    public function getIntFkErpUserRunway()
    {
        return $this->hasOne(ErpUserRunway::className(), ['INT_PK_ID_ERP_USER_RUNWAY' => 'INT_FK_ERP_USER_RUNWAY_ID']);
    }
    public function getIntFkErpMenu()
    {
        return $this->hasOne(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU_ID']);
    }
}