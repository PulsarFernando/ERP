<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\ErpMenu;
use app\models\ErpRole;
use app\models\ErpMenuHasErpRoleSearch;
class AjaxSwitchController extends Controller
{
	public function actionGetManagementRolePermission()
	{
		$objErpMenu = new ErpMenu();
		$objErpRole = new ErpRole();
		$objErpMenuHasErpRoleSearch = new ErpMenuHasErpRoleSearch();
		$objErpMenuHasErpRoleSearch->getRoleAndMenu();
		
		
		//echo '<pre>';
		//print_r($objErpMenu->find()->asArray()->where('INT_FK_ERP_MENU > 0')->orderBy('STR_MENU_NAME')->all());
		//die;
		
		return $this->render('getManagementRolePermission', [
			'arrErpMainMenu'	=> $objErpMenu->find()->asArray()->where('INT_FK_ERP_MENU IS NULL')->orderBy('STR_MENU_NAME')->all(),
			'arrErpSubMenu'		=> $objErpMenu->find()->asArray()->where('INT_FK_ERP_MENU > 0')->orderBy('STR_MENU_NAME')->all(),
		]);
	}
	
}