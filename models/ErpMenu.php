<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class ErpMenu extends ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_MENU';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['BOO_STATUS', 'BOO_MAIN_MENU'], 'integer'],
            [['STR_MENU_NAME', 'BOO_STATUS'], 'required'],
            [['STR_MENU_NAME', 'STR_URL'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_MENU' => 'Id',
            'STR_MENU_NAME' => 'Descrição',
            'STR_URL' => 'Url',
            'BOO_STATUS' => 'Status',
        	'BOO_MAIN_MENU' => 'Menu principal',
        ];
    }
    public function getIntFkErpMenu()
    {
        return $this->hasOne(ErpMenu::className(), ['INT_PK_ID_ERP_MENU' => 'INT_FK_ERP_MENU']);
    }
    public function getErpMenuHasErpRole()
    {
        return $this->hasMany(ErpMenuHasErpRole::className(), ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']);
    }
    public function getIntFkErpRole()
    {
        return $this->hasMany(ErpRole::className(), ['INT_PK_ID_ERP_ROLE' => 'INT_FK_ERP_ROLE_INT_ID'])->viaTable('ERP_MENU_HAS_ERP_ROLE', ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']);
    }
    public function getErpUserRunwayHasErpMenu()
    {
        return $this->hasMany(ErpUserRunwayHasErpMenu::className(), ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']);
    }
    public function getIntFkErpUserRunway()
    {
        return $this->hasMany(ErpUserRunway::className(), ['INT_PK_ID_ERP_USER_RUNWAY' => 'INT_FK_ERP_USER_RUNWAY_ID'])->viaTable('ERP_USER_RUNWAY_HAS_ERP_MENU', ['INT_FK_ERP_MENU_ID' => 'INT_PK_ID_ERP_MENU']);
    }
    public function getErpMenu($arrWhere, $strOrder)
    {
    	return $this->find()->asArray()->where($arrWhere)->orderBy($strOrder)->all();
    }
}
