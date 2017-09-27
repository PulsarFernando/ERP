<?php
namespace app\models;
use Yii;
class ErpRole extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_ROLE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_ROLE_NAME'], 'required'],
            [['TST_CREATION_DATE'], 'safe'],
            [['BOO_STATUS'], 'integer'],
            [['STR_ROLE_NAME'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_ROLE' => 'Id',
            'STR_ROLE_NAME' => 'Descrição do perfil',
            'TST_CREATION_DATE' => 'Data do registro',
            'BOO_STATUS' => 'Status',
        ];
    }
    public function getErpMenuHasErpRole()
    {
        return $this->hasMany(ErpMenuHasErpRole::className(), ['INT_FK_ERP_ROLE_INT_ID' => 'INT_PK_ID_ERP_ROLE']);
    }
    public function getIntFkErpMenu()
    {
        return $this->hasMany(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU_ID'])->viaTable('ERP_MENU_HAS_ERP_ROLE', ['INT_FK_ERP_ROLE_INT_ID' => 'INT_PK_ID_ERP_ROLE']);
    }
    public function getErpUser()
    {
        return $this->hasMany(ErpUser::className(), ['INT_FK_ERP_ROLE_ID' => 'INT_PK_ID_ERP_ROLE']);
    }
    public function getAllErpRole($strOrderBy)
    {
    	return $this->find()->asArray()->orderBy($strOrderBy)->all();
    }
}