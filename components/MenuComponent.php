<?php
namespace app\components;	
use yii;
use yii\base\Component;
use app\models\ErpMenuHasErpRoleSearch;
class MenuComponent extends Component
{
	public function getMainMenu()
	{
		$arrMenu = [];
		if(Yii::$app->session->get('strIdErpUser'))
			$arrMenu = self::getMainMenuByRole(Yii::$app->session->get('intErpRole'));
		return $arrMenu;
	}
	public function getMainMenuByRole($intErpRole)
	{
		$objErpMenuHasErpRole = new ErpMenuHasErpRoleSearch();
		$arrMenu = [];
		foreach ($objErpMenuHasErpRole->getMenuByRoleLevelStatus($intErpRole) as $objErpMainMenu)
		{
				$arrMenu[$objErpMainMenu->fkErpMenu->INT_PK_ID_ERP_MENU]['label'] = $objErpMainMenu->fkErpMenu->STR_MENU_NAME;
				if($objErpMainMenu->fkErpMenu->STR_URL)
					$arrMenu[$objErpMainMenu->fkErpMenu->INT_PK_ID_ERP_MENU]['url'] = $objErpMainMenu->fkErpMenu->STR_URL;
				foreach ($objErpMenuHasErpRole->getSubmenuByRoleLevelStatus($intErpRole, $objErpMainMenu->fkErpMenu->INT_PK_ID_ERP_MENU) as $objErpSubmenu)
				{
					$arrMenu[$objErpMainMenu->fkErpMenu->INT_PK_ID_ERP_MENU]['items'][$objErpSubmenu->fkErpMenu->INT_PK_ID_ERP_MENU]['label'] = $objErpSubmenu->fkErpMenu->STR_MENU_NAME;
					$arrMenu[$objErpMainMenu->fkErpMenu->INT_PK_ID_ERP_MENU]['items'][$objErpSubmenu->fkErpMenu->INT_PK_ID_ERP_MENU]['url'] = $objErpSubmenu->fkErpMenu->STR_URL;
				}
		}	
		return $arrMenu;
	}
	public function getSerializeMenuByRoleForAdministration()
	{
		$objErpMenuHasErpRoleSearch = new ErpMenuHasErpRoleSearch();
		$arrRoleAdmintrationMenuSelected = $objErpMenuHasErpRoleSearch->getRoleAdmintrationMenuSelected();
		foreach ($arrRoleAdmintrationMenuSelected as $arrLine)
			$arrReturn[$arrLine['INT_FK_ERP_ROLE_INT_ID']][($arrLine['INT_FK_ERP_MAIN_MENU_ID'] == null ? 0 : $arrLine['INT_FK_ERP_MAIN_MENU_ID'])][$arrLine['INT_FK_ERP_MENU_ID']] =  true;
		return $arrReturn;
	}
}