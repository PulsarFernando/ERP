<?php
namespace app\controllers;
use Yii;
use app\models\ErpUser;
use app\models\ErpUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ErpMenu;
use app\models\ErpRole;
use app\components\MenuComponent;
use app\models\ErpRoleSearch;
use app\models\ErpMenuSearch;
class BusinessManagementController extends Controller
{
    public function actionErpUser()
    {
    	$searchModel = new ErpUserSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    	
    	return $this->render('erpUser', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionErpUserAdd()
    {
    	$objErpUser = new ErpUser();
   		if ($objErpUser->load(Yii::$app->request->post()) && $objErpUser->save()) 
    		return $this->redirect('erp-user');
    	else
    	{	
    		return $this->render('erpUserAdd', [
    				'objErpUser' => $objErpUser,
    		]);
    	}
    }
    public function actionErpUserUpdate($id)
    {
    	$objErpUser = $this->findModelErpUser($id);
    	if ($objErpUser->load(Yii::$app->request->post()) && $objErpUser->save()) 
    		return $this->redirect(['erp-user', 'update' => 1]);
    	else
    	{
    		return $this->render('erpUserUpdate', [
    				'objErpUser' => $objErpUser,
    		]);
    	}
    }
    protected function findModelErpUser($id)
    {
    	if (($objErpUser = ErpUser::findOne($id)) !== null) 
    		return $objErpUser;
    	else
    		throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionErpRole()
    {
    	$objMenuComponent = new MenuComponent();
    	$objErpMenu = new ErpMenu();
    	$objErpRole = new ErpRole();
    	$arrErpRole = $objErpRole->getAllErpRole('STR_ROLE_NAME');
    	$arrSelected = $objMenuComponent->getSerializeMenuByRoleForAdministration();
    	return $this->render('erpRole', [
   			'arrErpRole'		=> $arrErpRole,
    		'arrErpMainMenu'	=> $objErpMenu->getErpMenu(['BOO_MAIN_MENU' => 1], 'STR_MENU_NAME'),
    		'arrErpSubMenu'		=> $objErpMenu->getErpMenu(['BOO_MAIN_MENU' => 0], 'STR_MENU_NAME'),
    		'arrSelected'		=> $arrSelected,	
    	]);
    }
    public function actionErpRoleAdm()
    {
   		$searchModel = new ErpRoleSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	return $this->render('erpRoleAdm', [
    		//'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    public function actionErpRoleUpdate($id)
    {
    	$objErpRole = $this->findModelErpRole($id);
    	
    	
    	if ($objErpRole->load(Yii::$app->request->post()) && $objErpRole->save())
    		return $this->redirect('erp-role-adm');
    	else 
    	{
    		return $this->render('erpRoleUpdate', [
    				'objErpRole' => $objErpRole,
    		]);
    	}
    }
    public function actionErpRoleAdd()
    {
    	$objErpRole = new ErpRole();
    	if ($objErpRole->load(Yii::$app->request->post())) 
    	{
    		$objErpRole->BOO_STATUS = 1;
    		if ($objErpRole->save())
    			return $this->redirect('erp-role-adm');
    	}
    	else 
    	{
    		return $this->render('erpRoleAdd', [
    				'objErpRole' => $objErpRole,
    		]);
    	}
    }
    protected function findModelErpRole($id)
    {
    	if (($objErpRole = ErpRole::findOne($id)) !== null) {
    		return $objErpRole;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    public function actionErpMenuAdm()
    {
    	$searchModel = new ErpMenuSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	return $this->render('erpMenuAdm', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionErpMenuUpdate($id)
    {
    	$objErpMenu = $this->findModelErpMenu($id);
    	if ($objErpMenu->load(Yii::$app->request->post()) && $objErpMenu->save())
    		return $this->redirect('erp-menu-adm?intTypeMenu='.Yii::$app->request->get('intTypeMenu'));
    	else
    	{
    		return $this->render('erpMenuUpdate', [
    				'objErpMenu' => $objErpMenu,
    		]);
    	}
    }
    public function actionErpMenuAdd()
    {
    	$objErpMenu = new ErpMenu();
    	if ($objErpMenu->load(Yii::$app->request->post()) && $objErpMenu->save())
    		return $this->redirect('erp-menu-adm?intTypeMenu='.Yii::$app->request->get('intTypeMenu'));
    	else
    	{
    		return $this->render('erpMenuAdd', [
    				'objErpMenu' => $objErpMenu,
    		]);
    	}
    }
    protected function findModelErpMenu($id)
    {
    	if (($objErpMenu = ErpMenu::findOne($id)) !== null) 
    		return $objErpMenu;
    	else
    		throw new NotFoundHttpException('The requested page does not exist.');
    }
}