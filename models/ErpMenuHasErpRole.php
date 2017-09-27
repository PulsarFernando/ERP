<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class ErpMenuHasErpRole extends ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_MENU_HAS_ERP_ROLE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_MENU_ID', 'INT_FK_ERP_ROLE_INT_ID'], 'required'],
            [['INT_FK_ERP_MENU_ID', 'INT_FK_ERP_ROLE_INT_ID', 'INT_FK_ERP_MAIN_MENU_ID', 'INT_MENU_POSITION'], 'integer'],
            [['INT_FK_ERP_MENU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ERPMENU::className(), 'targetAttribute' => ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']],
            [['INT_FK_ERP_ROLE_INT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ERPROLE::className(), 'targetAttribute' => ['INT_FK_ERP_ROLE_INT_ID' => 'INT_PK_ID_ERP_ROLE']],
            [['INT_FK_ERP_MAIN_MENU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ERPMENU::className(), 'targetAttribute' => ['INT_FK_ERP_MAIN_MENU_ID' => 'INT_PK_ID_ERP_MENU']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ERP_MENU_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Menu  ID'),
            'INT_FK_ERP_ROLE_INT_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Role  Int  ID'),
            'INT_FK_ERP_MAIN_MENU_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Main  Menu  ID'),
            'INT_MENU_POSITION' => Yii::t('erpModel', 'Int  Menu  Position'),
        ];
    }
    public function getFkErpMenu()
    {
        return $this->hasOne(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU_ID']);
    }
    public function getFkErpRole()
    {
        return $this->hasOne(ErpRole::className(), ['INT_PK_ID_ERP_ROLE' => 'INT_FK_ERP_ROLE_INT_ID']);
    }
    public function getFkErpMainMenu()
    {
        return $this->hasOne(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MAIN_MENU_ID']);
    }
}