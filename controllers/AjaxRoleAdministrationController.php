<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\ErpUserSearch;
use app\models\ErpRoleSearch;
use app\models\ErpMenuHasErpRoleSearch;
class AjaxRoleAdministrationController extends Controller
{
	public function actionSetVerifyRoleToDisable()
	{
		$objErpUserSearch = new ErpUserSearch();
		$objErpRoleSearch = new ErpRoleSearch();
		$objErpMenuHasErpRole = new ErpMenuHasErpRoleSearch();
		$intCountErpUser = $objErpUserSearch->getErpUserCountByRole(Yii::$app->request->post('intIdRole'));
		if($intCountErpUser > 0 && Yii::$app->request->post('intStatus') == 0)
			return false;
		else 
		{
			$objErpRoleSearch->updateStatusRole(Yii::$app->request->post('intIdRole'), Yii::$app->request->post('intStatus'));
			$objErpMenuHasErpRole->deleteMenuByArrParam(['INT_FK_ERP_ROLE_INT_ID' => Yii::$app->request->post('intIdRole')]);
			return true;
		}
	}
	public function actionSetMenuRoleSubmenu()
	{
		$objErpMenuHasErpRole = new ErpMenuHasErpRoleSearch();
		if(Yii::$app->request->post('booAddDelete') == 1)
			$objErpMenuHasErpRole->setRoleMenu(Yii::$app->request->post());
		else
			$objErpMenuHasErpRole->deleteMenuByArrParam(['INT_FK_ERP_MAIN_MENU_ID' => Yii::$app->request->post('intIdMainMenu'), 'INT_FK_ERP_MENU_ID' => Yii::$app->request->post('intIdSubMenu'), 'INT_FK_ERP_ROLE_INT_ID' => Yii::$app->request->post('intIdRole')]);
	}
	public function actionSetMenuRoleMainMenu()
	{
		$objErpMenuHasErpRole = new ErpMenuHasErpRoleSearch();
		if(Yii::$app->request->post('booAddDelete') == 1)
			$objErpMenuHasErpRole->setRoleMenu(Yii::$app->request->post(), true);
		else
			$objErpMenuHasErpRole->deleteMenuByArrParam(['INT_FK_ERP_MENU_ID' => Yii::$app->request->post('intIdSubMenu'), 'INT_FK_ERP_ROLE_INT_ID' => Yii::$app->request->post('intIdRole')]);
	}
}