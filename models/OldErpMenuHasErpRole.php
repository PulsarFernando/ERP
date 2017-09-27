<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class OldErpMenuHasErpRole extends ActiveRecord
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
            [['INT_FK_ERP_MENU_ID', 'INT_FK_ERP_ROLE_INT_ID'], 'integer'],
            [['INT_FK_ERP_MENU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpMenu::className(), 'targetAttribute' => ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']],
            [['INT_FK_ERP_ROLE_INT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpRole::className(), 'targetAttribute' => ['INT_FK_ERP_ROLE_INT_ID' => 'INT_PK_ID_ERP_ROLE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ERP_MENU_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Menu  ID'),
            'INT_FK_ERP_ROLE_INT_ID' => Yii::t('erpModel', 'Int  Fk  Erp  Role  Int  ID'),
        ];
    }
    public function getErpMenuByIntFk()
    {
        return $this->hasOne(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU_ID']);
    }
    public function getErpRoleByIntFk()
    {
        return $this->hasOne(ErpRole::className(), ['INT_PK_ID_ERP_ROLE' => 'INT_FK_ERP_ROLE_INT_ID']);
    }
}
