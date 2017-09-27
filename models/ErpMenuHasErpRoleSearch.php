<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpMenuHasErpRole;
class ErpMenuHasErpRoleSearch extends ErpMenuHasErpRole
{
    public function rules()
    {
        return [
            [['INT_FK_ERP_MENU_ID', 'INT_FK_ERP_ROLE_INT_ID','INT_FK_ERP_MAIN_MENU_ID','INT_MENU_POSITION'], 'integer'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpMenuHasErpRole::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_FK_ERP_MENU_ID' => $this->INT_FK_ERP_MENU_ID,
            'INT_FK_ERP_ROLE_INT_ID' => $this->INT_FK_ERP_ROLE_INT_ID,
        	'INT_FK_ERP_MAIN_MENU_ID' => $this->INT_FK_ERP_MAIN_MENU_ID,
        	'INT_MENU_POSITION' => $this->INT_MENU_POSITION,
        ]);
        return $dataProvider;
    }
    public function getMenuByRoleLevelStatus($intRole, $booMainMenu = 1, $booStatus = 1)
    {
    	return $this->find()
    		->innerJoinWith([
    			'fkErpMenu',
    			'fkErpRole',	
    		])
    		->innerJoinWith([
    				'fkErpMenu',
    		])
    		->where([
    			'INT_FK_ERP_ROLE_INT_ID' => $intRole,
    			ErpMenu::tableName().'.BOO_STATUS' => $booStatus,
    			ErpMenu::tableName().'.BOO_MAIN_MENU' => $booMainMenu,
    		])
    		->orderBy(['INT_MENU_POSITION' => 'ASC',ErpMenu::tableName().'.STR_MENU_NAME' => 'ASC'])
    	->all();
    }
    public function getSubmenuByRoleLevelStatus($intRole, $intIdMainMenu, $booStatus = 1)
    {
    	return $this->find()
	    	->innerJoinWith([
	    			'fkErpMenu',
	    			'fkErpRole',
	    	])
	    	->innerJoinWith([
	    			'fkErpMenu',
	    	])
	    	->where([
	    			'INT_FK_ERP_ROLE_INT_ID' => $intRole,
	    			'INT_FK_ERP_MAIN_MENU_ID' => $intIdMainMenu,
	    			ErpMenu::tableName().'.BOO_MAIN_MENU' => 0,
	    			ErpMenu::tableName().'.BOO_STATUS' => $booStatus,
	    	])
	    	->orderBy(['INT_MENU_POSITION' => 'ASC',ErpMenu::tableName().'.STR_MENU_NAME' => 'ASC'])
	    	->all();
    }
    public function getErpMenuHasErpRole($arrWhere, $strOrder = 'INT_MENU_POSITION')
    {
    	return $this->find()
	    	->innerJoinWith([
	    			'fkErpMenu',
	    			'fkErpRole',
	    	])
	    	->where($arrWhere)
	    	->orderBy($strOrder)
	    	->all();
    }
    public function getRoleAdmintrationMenuSelected()
    {
    	return $this->find()->orderBy('INT_FK_ERP_ROLE_INT_ID, INT_FK_ERP_MENU_ID, INT_FK_ERP_MAIN_MENU_ID')->asArray()->all();
    }
    public function deleteMenuByArrParam($arrKeyParam = [])
    {
    	return $this->deleteAll($arrKeyParam);
    }
    public function setRoleMenu($arrRoleMenuSubmenu, $booMainMenu = false)
    {
    	if($booMainMenu)
    		$this->INT_FK_ERP_MAIN_MENU_ID 	= NULL;
    	else 
    		$this->INT_FK_ERP_MAIN_MENU_ID 	= $arrRoleMenuSubmenu['intIdMainMenu'];
    	$this->INT_FK_ERP_MENU_ID 		= $arrRoleMenuSubmenu['intIdSubMenu'];
    	$this->INT_FK_ERP_ROLE_INT_ID 	= $arrRoleMenuSubmenu['intIdRole']; 
    	$this->INT_MENU_POSITION 		= 1;
    	return $this->save();
    }
}